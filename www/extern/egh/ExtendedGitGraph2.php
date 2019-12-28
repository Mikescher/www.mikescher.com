<?php

require_once 'Logger.php';
require_once 'RemoteSource.php';
require_once 'OutputGenerator.php';
require_once 'EGGDatabase.php';
require_once 'Utils.php';

class ExtendedGitGraph2 implements ILogger
{
	/** @var ILogger[] **/
	private $logger;

	/** @var IRemoteSource[] **/
	private $sources;

	/** @var IOutputGenerator[] **/
	private $outputter;

	/** @var EGGDatabase **/
	private $db;

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

		$this->sources = [];

		$sourcenames = [];
		foreach ($config['remotes'] as $rmt)
		{
			$newsrc = null;
			if ($rmt['type'] === 'github')
				$newsrc = new GithubConnection($this, $rmt['name'], $rmt['url'], $rmt['filter'], $rmt['exclusions'], $rmt['oauth_id'], $rmt['oauth_secret'], $rmt['token_cache'] );
			else if ($rmt['type'] === 'gitea')
				$newsrc = new GiteaConnection($this, $rmt['name'], $rmt['url'], $rmt['filter'], $rmt['exclusions'], $rmt['username'], $rmt['password'] );
			else
				throw new Exception("Unknown remote-type: " . $rmt['type']);

			if (array_key_exists($newsrc->getName(), $sourcenames)) throw new Exception("Duplicate source name: " . $newsrc->getName());

			$this->sources []= $newsrc;
			$sourcenames   []= $newsrc->getName();
		}

		$this->db = new EGGDatabase($config['data_cache_file'], $this);

		$this->outputter = new FullRenderer($this, $config['identities'], $config['output_cache_files']);
	}

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

			$this->db->deleteOldSources(array_map(function (IRemoteSource $v){ return $v->getName(); }, $this->sources));

			$this->proclog("Update finished.");

			$this->db->close();
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

	public function updateCache(): string
	{
		try
		{
			$this->db->open();

			$this->proclog("Start update cache");
			$this->proclog();

			$data = $this->outputter->updateCache($this->db);

			$this->db->close();
			$this->proclog("UpdateCache finished.");

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

	/**
	 * @return string|null
	 */
	public function loadFromCache()
	{
		try
		{
			$this->db->open();

			$data = $this->outputter->loadFromCache();

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
}