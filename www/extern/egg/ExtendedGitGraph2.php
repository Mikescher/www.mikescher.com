<?php

require_once 'IConfigSource.php';
require_once 'Logger.php';
require_once 'EGGException.php';
require_once 'RemoteSource.php';
require_once 'RemoteSourceGithub.php';
require_once 'RemoteSourceGitea.php';
require_once 'OutputGenerator.php';
require_once 'EGGDatabase.php';
require_once 'Utils.php';

class ExtendedGitGraph2 implements ILogger, IConfigSource
{
    /** @var ILogger[] **/
	private $logger;

	/** @var IRemoteSource[] **/
	private $sources;

	/** @var IOutputGenerator[] **/
	private $outputter;

	/** @var EGGDatabase **/
	private $db;

    public int $fetchLimitCommits  = 1024;
    public int $fetchLimitBranches = 64;
    public int $fetchLimitRepos    = 64;
    public int $fetchLimitOrgs     = 64;

	/**
	 * @param array $config
	 * @throws Exception
	 */
	public function __construct(array $config)
	{
		$this->logger = [];
		if ($config['output_session']) $this->logger []= new SessionLogger($config['session_var']);
		if ($config['output_stdout'])  $this->logger []= new OutputLogger();
		if ($config['output_logfile']) $this->logger []= new FileLogger($config['logfile'], $config['logfile_count']);
        if ($config['output_file'])    $this->logger []= new SingleFileLogger($config['output_filepath']);

        if (isset($config['fetchlimit_commits']))  $this->fetchLimitCommits  = intval($config['fetchlimit_commits']);
        if (isset($config['fetchlimit_branches'])) $this->fetchLimitBranches = intval($config['fetchlimit_branches']);
        if (isset($config['fetchlimit_repos']))    $this->fetchLimitRepos    = intval($config['fetchlimit_repos']);
        if (isset($config['fetchlimit_orgs']))     $this->fetchLimitOrgs     = intval($config['fetchlimit_orgs']);

		$this->sources = [];

		$sourcenames = [];
		foreach ($config['remotes'] as $rmt)
		{
			$newsrc = null;
			if ($rmt['type'] === 'github')
				$newsrc = new GithubConnection($this, $this, $rmt['name'], $rmt['url'], $rmt['filter'], $rmt['exclusions'], $rmt['oauth_id'], $rmt['oauth_secret'], $rmt['token_cache'] );
			else if ($rmt['type'] === 'gitea')
				$newsrc = new GiteaConnection($this, $this, $rmt['name'], $rmt['url'], $rmt['filter'], $rmt['exclusions'], $rmt['username'], $rmt['password'] );
			else
				throw new EGGException("Unknown remote-type: " . $rmt['type']);

			if (array_key_exists($newsrc->getName(), $sourcenames)) throw new EGGException("Duplicate source name: " . $newsrc->getName());

			$this->sources []= $newsrc;
			$sourcenames   []= $newsrc->getName();
		}

		$this->db = new EGGDatabase($config['data_cache_file'], $this);

		$this->outputter = new FullRenderer($this, $config['identities'], $config['output_cache_files']);
	}

    public function getFetchLimitCommits(): int  { return $this->fetchLimitCommits; }
    public function getFetchLimitBranches(): int { return $this->fetchLimitBranches; }
    public function getFetchLimitRepos(): int    { return $this->fetchLimitRepos; }
    public function getFetchLimitOrgs(): int     { return $this->fetchLimitOrgs; }

	public function update()
	{
		try
		{
			$this->db->open();

			$this->proclog("Start incremental data update");
			$this->proclog();

			foreach ($this->sources as $src)
			{
				$this->proclog("======= UPDATE " . $src->getName() . " =======");

				$src->update($this->db);

				$this->proclog();
			}

			$this->db->beginTransaction();
			$this->db->deleteOldSources(array_map(function (IRemoteSource $v){ return $v->getName(); }, $this->sources));
			$this->db->commitTransaction();

			$this->proclog("Update finished.");

			$this->proclog("Data written.");

			$this->db->close();

			return true;
		}
		catch (EGGException $exception)
		{
			$this->proclog("ExtendedGitGraph2::update failed:");
			$this->proclog($exception->egg_message);

			$this->db->abortTransactionIfExists();

			return false;
		}
		catch (Exception $exception)
		{
			$this->proclog("(!) FATAL ERROR -- UNCAUGHT EXCEPTION THROWN");
			$this->proclog();
			$this->proclog($exception->getMessage());
			$this->proclog();
			$this->proclog($exception->getTraceAsString());

			$this->db->abortTransactionIfExists();

			return false;
		}
	}

	public function updateCache(): ?string
	{
		try
		{
			$this->db->openReadOnly();
			$this->db->beginTransaction();

			$this->proclog("Start update cache");
			$this->proclog();

			$data = $this->outputter->updateCache($this->db);

			$this->db->close();
			$this->proclog("UpdateCache finished.");

			return $data;
		}
		catch (EGGException $exception)
		{
			$this->proclog("ExtendedGitGraph2::updateCache failed:");
			$this->proclog($exception->egg_message);

			$this->db->abortTransactionIfExists();

			return null;
		}
		catch (Exception $exception)
		{
			$this->proclog("(!) FATAL ERROR -- UNCAUGHT EXCEPTION THROWN");
			$this->proclog();
			$this->proclog($exception->getMessage());
			$this->proclog();
			$this->proclog($exception->getTraceAsString());

			return null;
		}
	}

	/**
	 * @return string|null
	 */
	public function loadFromCache()
	{
		try
		{
			$this->db->openReadOnly();

			$data = $this->outputter->loadFromCache();

			$this->db->close();

			return $data;
		}
		catch (Exception $exception)
		{
			$this->proclog("(!) FATAL ERROR -- UNCAUGHT EXCEPTION THROWN");
			$this->proclog();
			$this->proclog($exception->getMessage());
			$this->proclog();
			$this->proclog($exception->getTraceAsString());
		}
	}

	public function proclog($text = '')
	{
		foreach($this->logger as $lgr) $lgr->proclog($text);
	}

	/**
	 * @return string[]
	 */
	public function checkDatabase(): array
	{
		$this->db->open();

		$r = $this->db->checkDatabase();

		$this->db->close();

		return $r;
	}
}