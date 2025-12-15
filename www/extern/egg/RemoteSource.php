<?php

require_once 'IConfigSource.php';
require_once 'Utils.php';
require_once 'EGGDatabase.php';

interface IRemoteSource
{
	/** @param $db EGGDatabase */
	public function update(EGGDatabase $db);

	/** @return string **/
	public function getName();

	/** @return string **/
	public function toString();
}

abstract class StandardGitConnection implements IRemoteSource
{

    /** @var ILogger $logger */
    protected $logger;

    /** @var IConfigSource $cfgSource */
    protected $cfgSource;

	/** @var string $name */
	protected $name;

	/** @var string $filter */
	protected $filter;

	/** @var string[] exclusions */
	protected $exclusions;

	/**
     * @param ILogger $logger
     * @param IConfigSource $cfg
     * @param string $name
	 * @param string $filter
	 * @param string[] exclusions
	 */
	public function __construct(ILogger $logger, IConfigSource $cfg, string $name, string $filter, array $exclusions)
	{
        $this->logger       = $logger;
        $this->cfgSource    = $cfg;
		$this->name         = $name;
		$this->filter       = $filter;
		$this->exclusions   = $exclusions;
	}

	/** @inheritDoc
	 * @throws Exception
	 */
	public function update(EGGDatabase $db)
	{
		$this->preUpdate();

		$repos = $this->listAndUpdateRepositories($db);

		$anyChanged = false;

		foreach ($repos as $repo)
		{
            $branches = $this->listAndUpdateBranches($db, $repo);
            $this->logger->proclog("Found " . count($branches) . " branches in Repo: [" . $repo->Name . "]");

            foreach ($branches as $branch)
            {

                $db->beginTransaction();
                {
                    if ($branch->HeadFromAPI === $branch->Head)
                    {
                        $db->setUpdateDateOnBranch($branch);
                        $this->logger->proclog("Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] is up to date");
                        $db->commitTransaction();
                        continue;
                    }

                    $updateCount = $this->listAndUpdateCommits($db, $repo, $branch);
                    $db->setUpdateDateOnBranch($branch);
                    if ($updateCount === 0)
                    {
                        $this->logger->proclog("Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] has no new commits");
                        $db->commitTransaction();
                        continue;
                    }

                    $this->logger->proclog("Found " . $updateCount . " new commits in Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "]");

                    $anyChanged = true;

                    $db->setChangeDateOnBranch($branch);
                    $db->setChangeDateOnRepository($repo);
                    $db->setUpdateDateOnRepository($repo);
                }
                $db->commitTransaction();

            }

            $db->beginTransaction();
            $db->setUpdateDateOnRepository($repo);
            $db->commitTransaction();
		}

		if ($anyChanged)
		{
			$this->logger->proclog("Deleting dangling commit-data...");

			$db->deleteDanglingCommitdata();
		}

		$this->postUpdate();

		$this->logger->proclog("Finished [" . $this->name . "]");
	}

	/**
	 * @throws Exception
	 */
	protected abstract function preUpdate();

	/**
	 * @throws Exception
	 */
	protected abstract function postUpdate();

    /**
     * @param int $page
     * @return array
     */
    protected abstract function queryOrganizations($page);

	/**
	 * @param string $user
	 * @param int $page
	 * @return array
	 */
	protected abstract function queryRepositories($user, $page);

	/**
	 * @param string $reponame
	 * @param int $page
	 * @return array
	 */
	protected abstract function queryBranches($reponame, $page);

	/**
	 * @param string $reponame
	 * @param string $branchname
	 * @param string $startsha
	 * @return array
	 */
	protected abstract function queryCommits($reponame, $branchname, $startsha);

    /**
     * @param mixed $data
     * @return array
     * @throws Exception
     */
    protected abstract function readOrganization($data);

	/**
	 * @param mixed $data
	 * @return array
	 * @throws Exception
	 */
	protected abstract function readRepository($data);

	/**
	 * @param mixed $data
	 * @return array
	 * @throws Exception
	 */
	protected abstract function readBranch($data);

	/**
	 * @param mixed $data
	 * @return array
	 * @throws Exception
	 */
	protected abstract function readCommit($data);

	/**
	 * @param EGGDatabase $db
	 * @return Repository[]
	 * @throws Exception
	 */
	private function listAndUpdateRepositories(EGGDatabase $db) {
		$f = explode('/', $this->filter);

        $result = [];

        if ($f[0] === '*') {

            $page = 1;
            $json = $this->queryOrganizations($page);
            while (! empty($json)) {

                foreach ($json as $result_org) {

                    $jdata = $this->readOrganization($result_org);

                    $this->logger->proclog("Found Org in Remote: " . $jdata['full_name'] . " (" . $jdata['key'] . ")");

                    $r0 = $this->listAndUpdateRepositoriesOfOrganization($db, $jdata['key']);
                    $result = array_merge($result, $r0);

                }

                $page++;
                $json = $this->queryOrganizations($page);
            }


        } else {

            $r0 = $this->listAndUpdateRepositoriesOfOrganization($db, $f[0]);
            $result = array_merge($result, $r0);

        }

        $db->deleteOtherRepositories($this->name, $result);

		return $result;
	}

    private function listAndUpdateRepositoriesOfOrganization(EGGDatabase $db, string $org){

        $result = [];

        $page = 1;
        $json = $this->queryRepositories($org, $page);

        $found = [];
        while (! empty($json))
        {
            $count = 0;
            foreach ($json as $result_repo)
            {
                $jdata = $this->readRepository($result_repo);

                if (in_array($jdata['full_name'], $found)) continue;
                $found []= $jdata['full_name'];

                if (!Utils::isRepoFilterMatch($this->filter, $this->exclusions, $jdata['full_name']))
                {
                    $this->logger->proclog("Skip Repo: " . $jdata['full_name']);
                    continue;
                }

                $this->logger->proclog("Found Repo in Remote: " . $jdata['full_name']);

                $result []= $db->getOrCreateRepository($jdata['html_url'], $jdata['full_name'], $this->name);
                $count++;
            }

            if ($count === 0) break;

            $page++;
            $json = $this->queryRepositories($org, $page);
        }

        return $result;
    }

	/**
	 * @param EGGDatabase $db
	 * @param Repository $repo
	 * @return Branch[]
	 * @throws Exception
	 */
	private function listAndUpdateBranches(EGGDatabase $db, Repository $repo) {

		$result = [];

		$page = 1;
		$json = $this->queryBranches($repo->Name, $page);

		$found = [];
		while (! empty($json))
		{
			$count = 0;
			foreach ($json as $result_branch) {
				$jdata = $this->readBranch($result_branch);

				if ($jdata === null) continue;

				$bname = $jdata['name'];
				$bhead = $jdata['sha'];

				if (in_array($bname, $found)) continue;
				$found []= $bname;

				$this->logger->proclog("Found Branch in Remote: [" . $repo->Name . "] " . $bname);

				$b = $db->getOrCreateBranch($this->name, $repo, $bname);
				$b->HeadFromAPI = $bhead;
				$result []= $b;
				$count++;
			}

			if ($count === 0) break;

			$page++;
			$json = $this->queryBranches($repo->Name, $page);
		}

		$db->deleteOtherBranches($this->name, $repo, $result);

		return $result;
	}

	/**
	 * @param EGGDatabase $db
	 * @param Repository $repo
	 * @param Branch $branch
	 * @return Commit[]
	 * @throws Exception
	 */
	private function listAndUpdateCommits(EGGDatabase $db, Repository $repo, Branch $branch): int {

		if ($branch->Head !== null && $branch->HeadFromAPI === $branch->Head) return 0; // nothing to do

		/** @var Commit[] $queried_commits */
		$queried_commits = [];

		if ($branch->HeadFromAPI === null) return [];

		$target = $branch->Head;
		$oldHeadFound = false;

		$next_sha = [ $branch->HeadFromAPI ];

		$queryCounter=0;
		$reusedFromExistingCommitData = 0;
		$queriedFromAPI = 0;

		$visited = [];

		/** @var Commit[] $existingCommitData (hash -> Commit) */
		$existingCommitData = [];

		$this->logger->proclog("Query existing commits for [" . $this->name . "|" . $repo->Name . "] (re-use)");
		foreach ($db->getCommitdataForRepo($repo, $branch) as $c) $existingCommitData[$c->Hash] = $c;
		$this->logger->proclog("Found " . count($existingCommitData) . " existing commit-data in DB");

		/** @var Commit[] $unprocessed */
		$unprocessed = [];

		for (;;)
		{
			foreach ($unprocessed as $commit)
			{
				while (($rmshakey = array_search($commit->Hash, $next_sha)) !== false) unset($next_sha[$rmshakey]);

				if (in_array($commit->Hash, $visited)) continue;
				$visited []= $commit->Hash;

				if ($commit->Hash === $target) $oldHeadFound = true;

				$queried_commits []= $commit;

				foreach ($commit->Parents as $p)
				{
					$next_sha []= $p;
				}
			}

			$next_sha = array_values($next_sha); // fix numeric keys

			if (count($next_sha) === 0) break; // all leafs were processed, teh whole graph shoul have been handled

			if (array_key_exists($next_sha[0], $existingCommitData)) {

				// fast-track for existing Commit-Data
				$unprocessed = [ $existingCommitData[$next_sha[0]] ];
				$reusedFromExistingCommitData++;

			} else {

				$queryCounter++;
				if ($queryCounter === 1) {
					$this->logger->proclog("Query commits for [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] (initial @ {" . substr($next_sha[0], 0, 8) . "}) (target: {" . substr($target ?? 'NULL', 0, 8) . "})");
				} else {
					$this->logger->proclog("Query commits for [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] (" . $queryCounter . " @ {" . substr($next_sha[0], 0, 8) . "})");
				}

				$unprocessed = array_map(fn($p) => $this->createCommit($branch, $p), $this->queryCommits($repo->Name, $branch->Name, $next_sha[0]));
				$queriedFromAPI += count($unprocessed);

			}

		}

		if ($branch->Head === null) {

			// farm-fresh new branch

			$this->logger->proclog("HEAD pointer in new Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] set to {".substr($branch->HeadFromAPI ?? 'NULL', 0, 8)."} - Queried " . count($queried_commits) . " commits (reused $reusedFromExistingCommitData commits from DB)");

			$db->insertNewCommits($this->name, $repo, $branch, $queried_commits);
			$db->setBranchHead($branch, $branch->HeadFromAPI);

			return count($queried_commits);

		} else if ($oldHeadFound) {

			// normal update, a few commits were added

			$this->logger->proclog("Query existing commits in DB for [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "]");
			$commitsInDB = array_map(function(Commit $m):string{return $m->Hash;}, $db->getCommitsForBranch($branch));

			$actual_new_commits = array_filter($queried_commits, fn($p) => !in_array($p->Hash, $commitsInDB));

			$this->logger->proclog("Update Branch [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] HEAD from {".substr($branch->Head ?? 'NULL', 0, 8)."} to {".substr($branch->HeadFromAPI ?? 'NULL', 0, 8)."} by adding ".count($actual_new_commits)." new commits (total = ".count($queried_commits).")");

			$db->insertNewCommits($this->name, $repo, $branch, $actual_new_commits);
			$db->setBranchHead($branch, $branch->HeadFromAPI);

			return count($actual_new_commits);

		} else {

			// the old head was no longer found, some commits need to be deleted, do a full re-sync with the DB

			$this->logger->proclog("HEAD pointer in Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] no longer matches. Fully updating all " . count($queried_commits) . " commits (changing HEAD from {".substr($branch->Head ?? 'NULL', 0, 8)."} to {".substr($branch->HeadFromAPI ?? 'NULL', 0, 8)."} (reused $reusedFromExistingCommitData commits from DB)");

			$db->deleteAllCommits($branch);

			$db->insertNewCommits($this->name, $repo, $branch, $queried_commits);
			$db->setBranchHead($branch, $branch->HeadFromAPI);

			return count($queried_commits);

		}
	}

	private function createCommit(Branch $branch, $result_commit): Commit
	{
		$jdata = $this->readCommit($result_commit);

		$sha             = $jdata['sha'];
		$author_name     = $jdata['author_name'];
		$author_email    = $jdata['author_email'];
		$committer_name  = $jdata['committer_name'];
		$committer_email = $jdata['committer_email'];
		$message         = $jdata['message'];
		$date            = $jdata['date'];

		$parents         = $jdata['parents'];


		$commit = new Commit();
		$commit->Branch         = $branch;
		$commit->Hash           = $sha;
		$commit->AuthorName     = $author_name;
		$commit->AuthorEmail    = $author_email;
		$commit->CommitterName  = $committer_name;
		$commit->CommitterEmail = $committer_email;
		$commit->Message        = $message;
		$commit->Date           = $date;
		$commit->Parents        = $parents;

		return $commit;
	}

	/** @inheritDoc  */
	public function getName() { return $this->name; }

	/** @inheritDoc  */
	public abstract function toString();
}
