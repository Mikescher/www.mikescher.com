<?php

require_once 'Logger.php';
require_once 'Models.php';
require_once 'Utils.php';

class EGGDatabase
{
	/** @var string */
	private $path;

	/* @var PDO */
	private $pdo = null;

	/* @var ILogger */
	private $logger = null;

	/**
	 * @param $path string
	 * @param $log ILogger
	 */
	public function __construct(string $path, ILogger $log)
	{
		$this->path   = $path;
		$this->logger = $log;
	}

	public function open()
	{
		$exists = file_exists($this->path);

		if (!$exists) $this->logger->proclog("No database file found. Creating new at '" . $this->path . "'");

		$dsn = "sqlite:" . $this->path;
		$opt =
		[
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];

		$this->pdo = new PDO($dsn, null, null, $opt);

		if(!$exists) $this->init();
	}

	private function init()
	{
		$this->logger->proclog("Initialize new database '" . $this->path . "'");

		$this->query_from_file(__DIR__."/db_init.sql");
	}

	public function close()
	{
		$this->pdo = null; // https://stackoverflow.com/questions/18277233
	}

	/** @param $path string */
	public function query_from_file(string $path)
	{
		$sql = file_get_contents($path);

		$cmds = explode("/*----SPLIT----*/", $sql);

		foreach ($cmds as $cmd) $this->pdo->exec($cmd);
	}

	public function sql_query_assoc(string $query)
	{
		return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
	}

	public function sql_query_assoc_prep(string $query, array $params)
	{
		$stmt = $this->pdo->prepare($query);

		foreach ($params as $p)
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function sql_exec_prep(string $query, array $params)
	{
		$stmt = $this->pdo->prepare($query);

		foreach ($params as $p)
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();

		return $stmt->rowCount();
	}

	/**
	 * @param string $url
	 * @param string $name
	 * @param string $source
	 * @return Repository
	 * @throws Exception
	 */
	public function getOrCreateRepository(string $url, string $name, string $source)
	{
		$repo = $this->sql_query_assoc_prep("SELECT * FROM repositories WHERE url = :url",
			[
				[":url", $url, PDO::PARAM_STR],
			]);

		if (count($repo) === 0)
		{
			$this->sql_exec_prep("INSERT INTO repositories (url, name, source, last_update, last_change) VALUES (:url, :nam, :src, :lu, :lc)",
				[
					[":url", $url,            PDO::PARAM_STR],
					[":nam", $name,           PDO::PARAM_STR],
					[":src", $source,         PDO::PARAM_STR],
					[":lu",  Utils::sqlnow(), PDO::PARAM_STR],
					[":lc",  Utils::sqlnow(), PDO::PARAM_STR],
				]);

			$repo = $this->sql_query_assoc_prep("SELECT * FROM repositories WHERE url = :url",
				[
					[":url", $url, PDO::PARAM_STR],
				]);

			if (count($repo) === 0) throw new Exception("No repo after insert [" . $source . "|" . $name . "]");

			$this->logger->proclog("Inserted (new) repository [" . $source . "|" . $name . "] into database");
		}

		$r = new Repository();
		$r->ID         = $repo[0]['id'];
		$r->URL        = $repo[0]['url'];
		$r->Name       = $repo[0]['name'];
		$r->Source     = $repo[0]['source'];
		$r->LastUpdate = $repo[0]['last_update'];
		$r->LastChange = $repo[0]['last_change'];
		return $r;
	}

	/**
	 * @param string $source
	 * @param Repository $repo
	 * @param string $name
	 * @return Branch
	 * @throws Exception
	 */
	public function getOrCreateBranch(string $source, Repository $repo, string $name)
	{
		$branch = $this->sql_query_assoc_prep("SELECT * FROM branches WHERE repo_id = :rid AND name = :nam",
			[
				[":rid", $repo->ID, PDO::PARAM_INT],
				[":nam", $name,     PDO::PARAM_STR],
			]);

		if (count($branch) === 0)
		{
			$this->sql_exec_prep("INSERT INTO branches (repo_id, name, head, last_update, last_change) VALUES (:rid, :nam, :sha, :lu, :lc)",
				[
					[":rid", $repo->ID,       PDO::PARAM_INT],
					[":nam", $name,           PDO::PARAM_STR],
					[":sha", null,            PDO::PARAM_STR],
					[":lu",  Utils::sqlnow(), PDO::PARAM_STR],
					[":lc",  Utils::sqlnow(), PDO::PARAM_STR],
				]);

			$branch = $this->sql_query_assoc_prep("SELECT * FROM branches WHERE repo_id = :rid AND name = :nam",
				[
					[":rid", $repo->ID, PDO::PARAM_INT],
					[":nam", $name,     PDO::PARAM_STR],
				]);

			if (count($branch) === 0) throw new Exception("No branch after insert [" . $source . "|" . $repo->Name  . "|" . $name . "]");

			$this->logger->proclog("Inserted (new) branch [" . $source . "|" . $repo->Name  . "|" . $name . "] into database");
		}

		$r = new Branch();
		$r->ID         = $branch[0]['id'];
		$r->Name       = $branch[0]['name'];
		$r->Repo       = $repo;
		$r->Head       = $branch[0]['head'];
		$r->LastUpdate = $branch[0]['last_update'];
		$r->LastChange = $branch[0]['last_change'];
		return $r;
	}

	/**
	 * @param string $source
	 * @param Repository $repo
	 * @param Branch $branch
	 * @param Commit[] $commits
	 */
	public function insertNewCommits(string $source, Repository $repo, Branch $branch, array $commits) {
		$this->logger->proclog("Inserted " . count($commits) . " (new) commits into [" . $source . "|" . $repo->Name  . "|" . $branch->Name . "]");

		foreach ($commits as $commit)
		{
			$strparents = implode(";", $commit->Parents);

			$this->sql_exec_prep("INSERT INTO commits ([branch_id], [hash], [author_name], [author_email], [committer_name], [committer_email], [message], [date], [parent_commits]) VALUES (:brid, :sha, :an, :am, :cn, :cm, :msg, :dat, :prt)",
				[
					[":brid", $branch->ID,             PDO::PARAM_INT],
					[":sha",  $commit->Hash,           PDO::PARAM_STR],
					[":an",   $commit->AuthorName,     PDO::PARAM_STR],
					[":am",   $commit->AuthorEmail,    PDO::PARAM_STR],
					[":cn",   $commit->CommitterName,  PDO::PARAM_STR],
					[":cm",   $commit->CommitterEmail, PDO::PARAM_STR],
					[":msg",  $commit->Message,        PDO::PARAM_STR],
					[":dat",  $commit->Date,           PDO::PARAM_STR],
					[":prt",  $strparents,             PDO::PARAM_STR],
				]);

			$dbid = $this->sql_query_assoc_prep("SELECT id FROM commits WHERE [branch_id] = :brid AND [Hash] = :sha",
				[
					[":brid", $branch->ID,             PDO::PARAM_INT],
					[":sha",  $commit->Hash,           PDO::PARAM_STR],
				]);

			$commit->ID = $dbid[0]['id'];
		}
	}

	/**
	 * @param Branch $branch
	 * @param string $head
	 */
	public function setBranchHead(Branch $branch, string $head) {
		$this->sql_exec_prep("UPDATE branches SET head = :head WHERE id = :id",
			[
				[":id",   $branch->ID, PDO::PARAM_INT],
				[":head", $head,       PDO::PARAM_STR],
			]);

		$branch->Head = $head;
	}

	public function setUpdateDateOnRepository(Repository $repo) {
		$now = Utils::sqlnow();
		$this->sql_exec_prep("UPDATE repositories SET last_update = :now WHERE id = :id",
			[
				[":id",  $repo->ID, PDO::PARAM_INT],
				[":now", $now,      PDO::PARAM_STR],
			]);
		$repo->LastUpdate = $now;
	}

	public function setChangeDateOnRepository(Repository $repo) {
		$now = Utils::sqlnow();
		$this->sql_exec_prep("UPDATE repositories SET last_change = :now WHERE id = :id",
			[
				[":id",  $repo->ID, PDO::PARAM_INT],
				[":now", $now,      PDO::PARAM_STR],
			]);
		$repo->LastChange = $now;
	}

	public function setUpdateDateOnBranch(Branch $branch) {
		$now = Utils::sqlnow();
		$this->sql_exec_prep("UPDATE branches SET last_update = :now WHERE id = :id",
			[
				[":id",  $branch->ID, PDO::PARAM_INT],
				[":now", $now,        PDO::PARAM_STR],
			]);
		$branch->LastUpdate = $now;
	}

	public function setChangeDateOnBranch(Branch $branch) {
		$now = Utils::sqlnow();
		$this->sql_exec_prep("UPDATE branches SET last_change = :now WHERE id = :id",
			[
				[":id",  $branch->ID, PDO::PARAM_INT],
				[":now", $now,        PDO::PARAM_STR],
			]);
		$branch->LastChange = $now;
	}

	/**
	 * @param string $source
	 * @param Repository $repo
	 * @param Branch[] $branches
	 */
	public function deleteOtherBranches(string $source, Repository $repo, array $branches)
	{
		$db = $this->sql_query_assoc_prep("SELECT id, repo_id, name FROM branches WHERE repo_id = :rid",
			[
				[":rid", $repo->ID, PDO::PARAM_STR]
			]);

		foreach ($db as $dbname)
		{
			$exist = false;
			foreach ($branches as $brnch) if ($brnch->ID === $dbname['id']) $exist = true;

			if (!$exist) $this->deleteBranchRecursive($source, $repo->Name, $dbname['name'], $dbname['id']);
		}
	}

	/**
	 * @param string $source
	 * @param Repository[] $repos
	 */
	public function deleteOtherRepositories(string $source, array $repos)
	{
		$db = $this->sql_query_assoc_prep("SELECT id, url, name FROM repositories WHERE source = :src",
			[
				[":src", $source, PDO::PARAM_STR]
			]);

		foreach ($db as $dbname)
		{
			$exist = false;
			foreach ($repos as $rep) if ($rep->ID === $dbname['id']) $exist = true;

			if (!$exist) $this->deleteRepositoryRecursive($source, $dbname['name'], $dbname['id']);
		}
	}

	/**
	 * @param string $source
	 * @param string $name
	 * @param int $id
	 */
	private function deleteRepositoryRecursive(string $source, string $name, int $id)
	{
		$this->logger->proclog("Delete repository [".$source."|" . $name . "] from database (no longer exists)");

		$branches = $this->sql_query_assoc_prep("SELECT id FROM branches WHERE repo_id = :rid", [ [":rid", $id, PDO::PARAM_INT] ]);

		$this->sql_exec_prep("DELETE FROM repositories WHERE id = :id", [[":id", $id, PDO::PARAM_INT]]);
		$this->sql_exec_prep("DELETE FROM branches WHERE repo_id = :rid", [[":rid", $id, PDO::PARAM_INT]]);
		foreach ($branches as $branch) $this->sql_exec_prep("DELETE FROM commits WHERE branch_id = :bid", [[":bid", $branch["id"], PDO::PARAM_INT]]);
	}

	/**
	 * @param string $source
	 * @param string $reponame
	 * @param string $name
	 * @param int $id
	 */
	private function deleteBranchRecursive(string $source, string $reponame, string $name, int $id)
	{
		$this->logger->proclog("Delete branch [" . $source . "|" . $reponame . "|" . $name . "] from database (no longer exists)");

		$this->sql_exec_prep("DELETE FROM branches WHERE id = :bid",       [[":bid", $id, PDO::PARAM_INT]]);
		$this->sql_exec_prep("DELETE FROM commits WHERE branch_id = :bid", [[":bid", $id, PDO::PARAM_INT]]);
	}

	/**
	 * @param Branch $branch
	 */
	public function deleteAllCommits(Branch $branch) {
		$this->sql_exec_prep("DELETE FROM commits WHERE branch_id = :bid", [[":bid", $branch->ID, PDO::PARAM_INT]]);
	}

	public function deleteOldSources(array $sources)
	{
		$dbsources = $this->sql_query_assoc_prep("SELECT source FROM repositories GROUP BY source", []);

		foreach ($dbsources as $dbsrc)
		{
			$exist = false;
			foreach ($sources as $src) if ($src === $dbsrc['source']) $exist=true;

			if (!$exist)
			{
				$this->logger->proclog("Delete source [" . $dbsrc['source'] . "] from database (no longer exists)");
				$repos = $this->sql_query_assoc_prep("SELECT source,name,id FROM repositories WHERE source = :src", [ [":src", $dbsrc['source'], PDO::PARAM_STR] ]);

				foreach ($repos as $r) $this->deleteRepositoryRecursive($r['source'], $r['name'], $r['id']);
			}
		}
	}

	/**
	 * @param int $year
	 * @param string[] $identities
	 * @return array
	 */
	public function getCommitCountOfYearByDate(int $year, array $identities): array
	{
		$sql = file_get_contents(__DIR__ . "/db_queryyear.sql");

		$cond = "(1=0)";
		$prep =
			[
				[":year", "".$year, PDO::PARAM_STR]
			];
		$i=0;
		foreach ($identities as $ident)
		{
			$cond .= " OR (mail1 = :_".$i."_)";
			$prep []= [":_".$i."_", $ident, PDO::PARAM_STR];
			$i++;
			$cond .= " OR (mail2 = :_".$i."_)";
			$prep []= [":_".$i."_", $ident, PDO::PARAM_STR];
			$i++;
		}

		$sql = str_replace("/*{INDETITY_COND}*/", $cond, $sql);

		$rows = $this->sql_query_assoc_prep($sql, $prep);

		$r = [];
		foreach ($rows as $row) $r[$row['commitdate']] = $row['count'];

		return $r;
	}

	/**
	 * @return int[]
	 */
	public function getAllYears(): array
	{
		$rows = $this->sql_query_assoc("SELECT d FROM (SELECT cast(strftime('%Y', commits.date) as decimal) AS d FROM commits) GROUP BY d ORDER BY d");
		$r = [];
		foreach ($rows as $row) $r []= $row['d'];
		return $r;
	}
}