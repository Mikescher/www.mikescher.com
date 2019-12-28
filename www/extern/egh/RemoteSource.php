<?php

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

	/** @var string $name */
	protected $name;

	/** @var string $filter */
	protected $filter;

	/** @var string[] exclusions */
	protected $exclusions;

	/**
	 * @param ILogger $logger
	 * @param string $name
	 * @param string $filter
	 * @param string[] exclusions
	 */
	public function __construct(ILogger $logger, string $name, string $filter, array $exclusions)
	{
		$this->logger       = $logger;
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

		foreach ($repos as $repo)
		{
			$branches = $this->listAndUpdateBranches($db, $repo);
			$db->setUpdateDateOnRepository($repo);

			$repo_changed = false;
			foreach ($branches as $branch)
			{
				if ($branch->HeadFromAPI === $branch->Head)
				{
					$db->setUpdateDateOnBranch($branch);
					$this->logger->proclog("Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] is up to date");
					continue;
				}

				$commits = $this->listAndUpdateCommits($db, $repo, $branch);
				$db->setUpdateDateOnBranch($branch);
				if (count($commits) === 0)
				{
					$this->logger->proclog("Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] has no new commits");
					continue;
				}

				$this->logger->proclog("Found " . count($commits) . " new commits in Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "]");

				$repo_changed = true;
				$db->setChangeDateOnBranch($branch);
			}

			if ($repo_changed) $db->setChangeDateOnRepository($repo);
		}

		$this->postUpdate();
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
	 * @param string $user
	 * @param int $page
	 * @return array
	 */
	protected abstract function queryRepositories($user, $page);

	/**
	 * @param string $reponame
	 * @return array
	 */
	protected abstract function queryBranches($reponame);

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

		$page = 1;
		$json = $this->queryRepositories($f[0], $page);

		while (! empty($json))
		{
			foreach ($json as $result_repo)
			{
				$jdata = $this->readRepository($result_repo);

				if (!Utils::isRepoFilterMatch($this->filter, $this->exclusions, $jdata['full_name']))
				{
					$this->logger->proclog("Skip Repo: " . $jdata['full_name']);
					continue;
				}

				$this->logger->proclog("Found Repo in Remote: " . $jdata['full_name']);

				$result []= $db->getOrCreateRepository($jdata['html_url'], $jdata['full_name'], $this->name);
			}

			$page++;
			$json = $this->queryRepositories($f[0], $page);
		}

		$db->deleteOtherRepositories($this->name, $result);

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

		$json = $this->queryBranches($repo->Name);

		foreach ($json as $result_branch) {
			$jdata = $this->readBranch($result_branch);

			if ($jdata === null) continue;

			$bname = $jdata['name'];
			$bhead = $jdata['sha'];

			$this->logger->proclog("Found Branch in Remote: [" . $repo->Name . "] " . $bname);

			$b = $db->getOrCreateBranch($this->name, $repo, $bname);
			$b->HeadFromAPI = $bhead;
			$result []= $b;
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
	private function listAndUpdateCommits(EGGDatabase $db, Repository $repo, Branch $branch) {

		$newcommits = [];

		if ($branch->HeadFromAPI === null) return [];

		$target = $branch->Head;

		$next_sha = [ $branch->HeadFromAPI ];
		$visited  = [ $branch->HeadFromAPI ];

		$json = $this->queryCommits($repo->Name, $branch->Name, $next_sha[0]);

		for (;;)
		{
			foreach ($json as $result_commit)
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

				if (($rmshakey = array_search($sha, $next_sha)) !== false) unset($next_sha[$rmshakey]);

				if (in_array($sha, $visited)) continue;
				$visited []= $sha;

				if ($sha === $target && count($next_sha) === 0)
				{
					if (count($newcommits) === 0)
					{
						$this->logger->proclog("Found no new commits for: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "]  (HEAD at {" . substr($branch->HeadFromAPI, 0, 8) . "})");
						return [];
					}

					$db->insertNewCommits($this->name, $repo, $branch, $newcommits);
					$db->setBranchHead($branch, $branch->HeadFromAPI);

					return $newcommits;
				}

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

				$newcommits []= $commit;

				foreach ($parents as $p)
				{
					$next_sha []= $p;
				}
			}

			$next_sha = array_values($next_sha); // fix numeric keys
			if (count($next_sha) === 0) break;

			$json = $this->queryCommits($repo->Name, $branch->Name, $next_sha[0]);
		}

		$this->logger->proclog("HEAD pointer in Branch: [" . $this->name . "|" . $repo->Name . "|" . $branch->Name . "] no longer matches. Re-query all " . count($newcommits) . " commits (old HEAD := {".substr($branch->Head, 0, 8)."})");

		$db->deleteAllCommits($branch);

		if (count($newcommits) === 0) return [];

		$db->insertNewCommits($this->name, $repo, $branch, $newcommits);
		$db->setBranchHead($branch, $branch->HeadFromAPI);

		return $newcommits;
	}

	/** @inheritDoc  */
	public function getName() { return $this->name; }

	/** @inheritDoc  */
	public abstract function toString();
}

class GithubConnection extends StandardGitConnection
{
	const API_OAUTH_AUTH  = 'https://github.com/login/oauth/authorize?client_id=%s';
	const URL_OAUTH_TOKEN = 'https://github.com/login/oauth/access_token?client_id={id}&client_secret={secret}&code={code}';

	const API_RATELIMIT        = 'https://api.github.com/rate_limit';
	const API_REPOSITORIESLIST = 'https://api.github.com/users/{user}/repos?page={page}&per_page=100';
	const API_COMMITSLIST      = 'https://api.github.com/repos/{repo}/commits?per_page=100&sha={sha}';
	const API_BRANCHLIST       = 'https://api.github.com/repos/{repo}/branches';

	/** @var string $url */
	private $url;

	/** @var string $oauth_id */
	private $oauth_id;

	/** @var string $oauth_secret */
	private $oauth_secret;

	/** @var string $apitokenpath */
	private $apitokenpath;

	/** @var string $apitoken */
	private $apitoken;

	/**
	 * @param ILogger $logger
	 * @param string $name
	 * @param string $url
	 * @param string $filter
	 * @param string[] exclusions
	 * @param string $oauth_id
	 * @param string $oauth_secret
	 * @param string $apitokenpath
	 */
	public function __construct(ILogger $logger, string $name, string $url, string $filter, array $exclusions, string $oauth_id, string $oauth_secret, string $apitokenpath)
	{
		parent::__construct($logger, $name, $filter, $exclusions);

		$this->url          = $url;
		$this->oauth_id     = $oauth_id;
		$this->oauth_secret = $oauth_secret;
		$this->apitokenpath = $apitokenpath;

		if ($this->apitokenpath !== null && file_exists($this->apitokenpath))
			$this->apitoken = file_get_contents($this->apitokenpath);
		else
			$this->apitoken = null;
	}

	/**
	 * @throws Exception
	 */
	public function queryAPIToken() {
		$url = Utils::sharpFormat(self::URL_OAUTH_TOKEN, ['id'=>$this->oauth_id, 'secret'=>$this->oauth_secret, 'code'=>'egg']);
		$fullresult = $result = file_get_contents($url);

		$result = str_replace('access_token=', '', $result);
		$result = str_replace('&scope=&token_type=bearer', '', $result);

		$this->logger->proclog("Updated Github API token");

		if (Utils::startsWith($result, "error=")) throw new Exception($fullresult);

		if ($result!=='' && $result !== null && $this->apitokenpath !== null)
			file_put_contents($this->apitokenpath, $result);

		$this->apitoken = $result;
	}

	/** @inheritDoc */
	protected function preUpdate()
	{
		if ($this->apitoken === null) $this->queryAPIToken();
	}

	/** @inheritDoc */
	protected function postUpdate()
	{
		//
	}

	/** @inheritDoc */
	protected function queryRepositories($user, $page)
	{
		$url = Utils::sharpFormat(self::API_REPOSITORIESLIST, ['user'=>$user, 'page'=>$page]);
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

	/** @inheritDoc */
	protected function queryBranches($reponame)
	{
		$url = Utils::sharpFormat(self::API_BRANCHLIST, ['repo'=>$reponame]);
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

	/** @inheritDoc */
	protected function queryCommits($reponame, $branchname, $startsha)
	{
		$url = Utils::sharpFormat(self::API_COMMITSLIST, [ 'repo'=>$reponame, 'sha'=>$startsha ]);
		$this->logger->proclog("Query commits from: [" . $this->name . "|" . $reponame . "|" . $branchname . "] continuing at {" . substr($startsha, 0, 8) . "}");
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

	/** @inheritDoc */
	protected function readRepository($data)
	{
		return
		[
			'full_name' => $data->{'full_name'},
			'html_url'  => $data->{'html_url'},
		];
	}

	/** @inheritDoc */
	protected function readBranch($data)
	{
		if (isset($data->{'block'})) return null;

		return
		[
			'name' => $data->{'name'},
			'sha'  => $data->{'commit'}->{'sha'},
		];
	}

	/** @inheritDoc */
	protected function readCommit($data)
	{
		return
		[
			'sha'              => $data->{'sha'},

			'author_name'      => $data->{'commit'}->{'author'}->{'name'},
			'author_email'     => $data->{'commit'}->{'author'}->{'email'},

			'committer_name'   => $data->{'commit'}->{'committer'}->{'name'},
			'committer_email'  => $data->{'commit'}->{'committer'}->{'email'},

			'message'          => $data->{'commit'}->{'message'},
			'date'             => (new DateTime($data->{'commit'}->{'author'}->{'date'}))->format("Y-m-d H:i:s"),

			'parents'          => array_map(function ($v){ return $v->{'sha'}; }, $data->{'parents'}),
		];
	}

	/** @inheritDoc  */
	public function toString() { return "[Github|".$this->filter."]"; }
}

class GiteaConnection extends StandardGitConnection
{
	const API_BASE_URL     = '/api/v1';

	const API_USER_REPO_LIST = '/users/{user}/repos';
	const API_BRANCH_LIST    = '/repos/{repo}/branches';
	const API_COMMIT_LIST    = '/repos/{repo}/commits?sha={sha}';

	/** @var string $url */
	private $url;

	/** @var string $username */
	private $username;

	/** @var string $password */
	private $password;

	/**
	 * @param ILogger $logger
	 * @param string $name
	 * @param string $url
	 * @param string $filter
	 * @param string[] $exclusions
	 * @param string $username
	 * @param string $password
	 */
	public function __construct(ILogger $logger, string $name, string $url, string $filter, array $exclusions, string $username, string $password)
	{
		parent::__construct($logger, $name, $filter, $exclusions);

		$this->url          = $url;
		$this->username     = $username;
		$this->password     = $password;
	}

	/** @inheritDoc */
	protected function preUpdate()
	{
		//
	}

	/** @inheritDoc */
	protected function postUpdate()
	{
		//
	}

	/** @inheritDoc */
	protected function queryRepositories($user, $page)
	{
		if ($page > 1) return [];
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_USER_REPO_LIST), ['user'=>$user ]);
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
	}

	/** @inheritDoc */
	protected function queryBranches($reponame)
	{
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_BRANCH_LIST), ['repo'=>$reponame]);
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
	}

	/** @inheritDoc */
	protected function queryCommits($reponame, $branchname, $startsha)
	{
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_COMMIT_LIST), [ 'repo'=>$reponame, 'sha'=>$startsha ]);
		$this->logger->proclog("Query commits from: [" . $this->name . "|" . $reponame . "|" . $branchname . "] continuing at {" . substr($startsha, 0, 8) . "}");
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
	}

	/** @inheritDoc */
	protected function readRepository($data)
	{
		return
		[
			'full_name' => $data->{'full_name'},
			'html_url'  => $data->{'html_url'},
		];
	}

	/** @inheritDoc */
	protected function readBranch($data)
	{
		return
		[
			'name' => $data->{'name'},
			'sha'  => $data->{'commit'}->{'id'},
		];
	}

	/** @inheritDoc */
	protected function readCommit($data)
	{
		return
		[
			'sha'              => $data->{'commit'}->{'tree'}->{'sha'},

			'author_name'      => $data->{'commit'}->{'author'}->{'name'},
			'author_email'     => $data->{'commit'}->{'author'}->{'email'},

			'committer_name'   => $data->{'commit'}->{'committer'}->{'name'},
			'committer_email'  => $data->{'commit'}->{'committer'}->{'email'},

			'message'          => $data->{'commit'}->{'message'},
			'date'             => (new DateTime($data->{'commit'}->{'author'}->{'date'}))->format("Y-m-d H:i:s"),

			'parents'          => array_map(function ($v){ return $v->{'sha'}; }, $data->{'parents'}),
		];
	}

	/** @inheritDoc  */
	public function toString() { return "[Gitea|".$this->url."|".$this->filter."]"; }
}