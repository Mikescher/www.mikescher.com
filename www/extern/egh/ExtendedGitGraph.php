<?php

require_once 'EGHRemoteConfig.php';
require_once 'ConnectionGithub.php';
require_once 'ConnectionGitea.php';
require_once 'SingleCommitInfo.php';
require_once 'EGHRenderer.php';

class ExtendedGitGraph
{
	const OUT_SESSION = 0;
	const OUT_STDOUT  = 1;
	const OUT_LOGFILE = 2;

	const PROGRESS_SESSION_COOKIE = 'ajax_progress_egh_refresh';

	const COMMITCOUNT_COLOR_UPPERLIMIT = 16;

	/* @var string */
	private $filenamecache;
	/* @var EGHRemoteConfig[] */
	private $remoteconfigs;

	/* @var ConnectionGithub */
	public $ConnectionGithub;
	/* @var ConnectionGitea */
	public $ConnectionGitea;

	/* @var int */
	private $outputMode = self::OUT_SESSION;
	/* @var string */
	private $logFilePath;
	/* @var array */
	private $renderedHTML;
	/* @var SingleCommitInfo[] */
	private $queriedData;

	/* @var string */
	private $colorScheme = 'blue';

	public function __construct($filename_cache, $outmode, $logfile) {
		$this->filenamecache = $filename_cache;
		$this->remoteconfigs = [];
		$this->ConnectionGithub = new ConnectionGithub($this);
		$this->ConnectionGitea = new ConnectionGitea($this);
		$this->outputMode = $outmode;
		$this->logFilePath = $logfile;
	}

	public function addRemote($type, $url, $user, $param) {
		$this->remoteconfigs []= new EGHRemoteConfig($type, $url, $user, $param);
	}

	public function setColorScheme($s) {
		$this->colorScheme = $s;
	}

	public function out($txt)
	{
		if ($txt !== '') $txt = '[' . date('H:i:s') . '] ' . $txt;

		if ($this->outputMode === self::OUT_SESSION)
		{
			if (session_status() !== PHP_SESSION_ACTIVE) session_start();

			$_SESSION[self::PROGRESS_SESSION_COOKIE] .= $txt . "\r\n";
			session_commit();
		}
		else if ($this->outputMode === self::OUT_STDOUT)
		{
			print $txt;
			print "\r\n";
		}

		$logfile = Utils::sharpFormat($this->logFilePath, ['num'=>'']);
		file_put_contents($logfile, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	}

	public function init()
	{
		if ($this->outputMode === self::OUT_SESSION)
		{
			if (session_status() !== PHP_SESSION_ACTIVE) session_start();
			$_SESSION[self::PROGRESS_SESSION_COOKIE] = '';
			session_commit();
		}

		$f3 = Utils::sharpFormat($this->logFilePath, ['num'=>'_3']);
		$f2 = Utils::sharpFormat($this->logFilePath, ['num'=>'_2']);
		$f1 = Utils::sharpFormat($this->logFilePath, ['num'=>'_1']);
		$f0 = Utils::sharpFormat($this->logFilePath, ['num'=>''  ]);

		if (file_exists($f3)) @unlink($f3);
		if (file_exists($f2)) @rename($f2, $f3);
		if (file_exists($f1)) @rename($f1, $f2);
		if (file_exists($f0)) @rename($f0, $f1);
		if (file_exists($f0)) @unlink($f0);

		$this->out('EXTENDED_GIT_GRAPH started');
		$this->out('');
	}

	public function updateFromRemotes()
	{
		$data = [];

		foreach ($this->remoteconfigs as $cfg)
		{
			if ($cfg->Type === 'github-user')
				$data = array_merge($data, $this->ConnectionGithub->getDataUser($cfg));
			else if ($cfg->Type === 'github-repository')
				$data = array_merge($data, $this->ConnectionGithub->getDataRepository($cfg));
			else if ($cfg->Type === 'gitea-user')
				$data = array_merge($data, $this->ConnectionGitea->getDataUser($cfg));
			else if ($cfg->Type === 'gitea-repository')
				$data = array_merge($data, $this->ConnectionGitea->getDataRepository($cfg));
			else
				$this->out("Unknown type: " . $cfg->Type);
		}

		$this->out("Found " . count($data) . " commits.");

		file_put_contents($this->filenamecache, serialize($data));

		$this->queriedData = $data;

	}

	public function updateFromCache()
	{
		if (file_exists($this->filenamecache))
			$this->queriedData = unserialize(file_get_contents($this->filenamecache));
		else
			$this->queriedData = [];
	}

	public function generate()
	{
		$renderer = new EGHRenderer($this);
		$renderer->colorScheme = $this->colorScheme;

		$renderer->init($this->queriedData);

		$this->renderedHTML = [];
		foreach ($renderer->yearList as $y) $this->renderedHTML[$y] = $renderer->render($y);
	}

	/**
	 * @param $url string
	 * @return array|mixed
	 */
	public function getJSON($url) {
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
			$options  =
				[
					'http'  => ['user_agent'=> $_SERVER['HTTP_USER_AGENT']],
					'https' => ['user_agent'=> $_SERVER['HTTP_USER_AGENT']],
				];
		} else {
			$options  =
				[
					'http'  => ['user_agent'=> 'ExtendedGitGraph_for_mikescher.com'],
					'https' => ['user_agent'=> 'ExtendedGitGraph_for_mikescher.com'],
				];
		}

		$context  = stream_context_create($options);

		$response = @file_get_contents($url, false, $context);

		if ($response === false)
		{
			$this->out("Error recieving json: '" . $url . "'");
			return [];
		}

		return json_decode($response);
	}

	public function get()
	{
		return $this->renderedHTML;
	}
}