<?php

require_once 'ruleengine.php';
require_once 'urlroute.php';
require_once 'pageframeoptions.php';

require_once 'utils.php';

class Website
{
	/** @var Website */
	private static $instance;

	/** @var array */
	public $config;

	/** @var bool|null */
	public $isLoggedIn = null;

	/** @var Database|null */            private $database = null;
	/** @var AdventOfCode|null */        private $adventOfCode = null;
	/** @var Blog|null */                private $blog = null;
	/** @var Books|null */               private $books = null;
	/** @var Euler|null */               private $euler = null;
	/** @var Programs|null */            private $programs = null;
	/** @var AlephNoteStatistics|null */ private $anstats = null;
	/** @var UpdatesLog|null */          private $updateslog = null;
	/** @var WebApps|null */             private $webapps = null;
	/** @var MikescherGitGraph|null */   private $extendedgitgraph = null;

	public function init()
	{
		set_error_handler("exception_error_handler"); // errors as exceptions for global catch

		try
		{
			$this->config = require (__DIR__ . "/../config.php");

			if (!$this->config['prod'])
			{
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);
			}

			self::$instance = $this;
		}
		catch (exception $e)
		{
			$this->serveServerError("Initialization failed", formatException($e), null);
		}
	}

	public static function inst()
	{
		return self::$instance;
	}

	public function serve($rules)
	{
		try
		{
			$route = RuleEngine::findRoute($this, $rules);

			$result = $route->get($this);

			if ($result->force_404)
			{
				$this->serveCustom404($route->full_url, $result);
				exit();
			}

			if ($result->contentType !== null) header('Content-Type: ' . $result->contentType);
			http_response_code($result->statuscode);

			$this->output($result, $route);

			exit();
		}
		catch (Exception $e)
		{
			$this->serveServerError(null, formatException($e), null);
		}
	}

	private function serveCustom404(string $uri, PageFrameOptions $frameOpt)
	{
		try
		{
			@ob_end_clean();

			$frameOpt->statuscode = 404;
			$frameOpt->title = 'Page not found';

			$route = URLRoute::getNotFoundRoute($uri);

			$result = $route->getDirect($this, $frameOpt);

			$this->output($result, $route);
		}
		catch (Exception $e)
		{
			$this->serveServerError(null, formatException($e), null);
		}

		exit();
	}

	/**
	 * @param string|null $message
	 * @param string|null $debugInfo
	 * @param PageFrameOptions|null $frameOpt
	 */
	private function serveServerError($message, $debugInfo, $frameOpt)
	{
		try
		{
			@ob_end_clean();

			if ($frameOpt === null) $frameOpt = new PageFrameOptions();

			$frameOpt->statuscode = 500;
			$frameOpt->title = 'Internal Server Error';
			$frameOpt->frame = 'error_frame.php';

			$route = URLRoute::getServerErrorRoute($_SERVER['REQUEST_URI']);

			$route->parameter['message']   = $message;
			$route->parameter['debuginfo'] = $debugInfo;

			$result = $route->getDirect($this, $frameOpt);

			$this->output($result, $route);
		}
		catch (Exception $e)
		{
			http_response_code(500);
			die('Internal Server Error');
		}

		exit();
	}

	private function output(PageFrameOptions $pfo, URLRoute $route)
	{
		if ($pfo->contentType !== null) header('Content-Type: ' . $pfo->contentType);
		http_response_code($pfo->statuscode);

		global $ROUTE;
		global $FRAME_OPTIONS;
		global $SITE;
		$ROUTE = $route;
		$FRAME_OPTIONS = $pfo;
		$SITE = $this;

		/** @noinspection PhpIncludeInspection */
		require __DIR__ . '/../frames/' . $FRAME_OPTIONS->frame;
	}

	public function Database()
	{
		if ($this->database === null) { require_once 'database.php'; $this->database = new Database($this); }
		return $this->database;
	}

	public function AdventOfCode(): AdventOfCode
	{
		if ($this->adventOfCode === null) { require_once 'adventofcode.php'; $this->adventOfCode = new AdventOfCode(); }
		return $this->adventOfCode;
	}

	public function Blog(): Blog
	{
		if ($this->blog === null) { require_once 'blog.php'; $this->blog = new Blog(); }
		return $this->blog;
	}

	public function Books(): Books
	{
		if ($this->books === null) { require_once 'books.php'; $this->books = new Books(); }
		return $this->books;
	}

	public function Euler(): Euler
	{
		if ($this->euler === null) { require_once 'euler.php'; $this->euler = new Euler(); }
		return $this->euler;
	}

	public function Programs(): Programs
	{
		if ($this->programs === null) { require_once 'programs.php'; $this->programs = new Programs(); }
		return $this->programs;
	}

	public function AlephNoteStatistics(): AlephNoteStatistics
	{
		if ($this->anstats === null) { require_once 'alephnoteStatistics.php'; $this->anstats = new AlephNoteStatistics($this); }
		return $this->anstats;
	}

	public function UpdatesLog(): UpdatesLog
	{
		if ($this->updateslog === null) { require_once 'updateslog.php'; $this->updateslog = new UpdatesLog($this); }
		return $this->updateslog;
	}

	public function WebApps(): WebApps
	{
		if ($this->webapps === null) { require_once 'webapps.php'; $this->webapps = new WebApps(); }
		return $this->webapps;
	}

	public function ExtendedGitGraph(): MikescherGitGraph
	{
		if ($this->extendedgitgraph === null) { require_once 'mikeschergitgraph.php'; $this->extendedgitgraph = new MikescherGitGraph($this); }
		return $this->extendedgitgraph;
	}

	/**
	 * @return bool
	 */
	public function isProd()
	{
		if ($this->config == null) return true;
		return $this->config['prod'];
	}

	public function isLoggedInByCookie()
	{
		if ($this->isLoggedIn !== null) return $this->isLoggedIn;

		if (key_exists('mikescher_auth', $_COOKIE))
		{
			if (strlen($_COOKIE['mikescher_auth']) !== 64) return ($this->isLoggedIn = false);
			$auth = hash('sha256', $this->config['admin_username'] . ';' . $this->config['admin_password'] . ';' . gmdate('Y-m-d'));
			if ($auth === $_COOKIE['mikescher_auth']) return ($this->isLoggedIn = true);
		}

		return ($this->isLoggedIn = false);
	}

	function setLoginCookie($user, $pass)
	{
		$expires = time() + (24*60*60); // 24h
		$hash = hash('sha256', $user . ';' . $pass . ';' . gmdate('Y-m-d'));
		setcookie('mikescher_auth', $hash, $expires);
	}

	function clearLoginCookie()
	{
		setcookie("mikescher_auth", "", time()+30);
	}

}

/**
 * @param $severity
 * @param $message
 * @param $file
 * @param $line
 * @throws ErrorException
 */
function exception_error_handler($severity, $message, $file, $line) {
	// This error code is not included in error_reporting
	if (!(error_reporting() & $severity)) return;
	throw new ErrorException($message, 0, $severity, $file, $line);
}