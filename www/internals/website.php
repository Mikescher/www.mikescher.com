<?php

require_once 'ruleengine.php';
require_once 'urlroute.php';
require_once 'pageframeoptions.php';
require_once 'iwebsitemodule.php';
require_once 'modules.php';
require_once 'fragments.php';

require_once 'utils.php';

class Website
{
	/** @var Website */
	private static $instance;

	/** @var array */
	public $config;

	/** @var bool|null */
	private $isLoggedIn = null;

	/** @var Modules */
	public $modules;

	/** @var Fragments */
	public $fragments;

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

			$this->modules = new Modules($this);

			$this->fragments = new Fragments();

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

			if ($result->force_redirect)
			{
				header('Location: ' . $result->force_redirect_url); // http 302: Found
				exit();
			}

			if ($result->force_404)
			{
				$this->serveCustom404($route->full_url, $result, $result->force_404_message);
				exit();
			}

			$this->output($result, $route);
		}
		catch (Exception $e)
		{
			$this->serveServerError("Internal Server Error", formatException($e), null);
		}
	}

	private function serveCustom404(string $uri, PageFrameOptions $frameOpt, string $message)
	{
		try
		{
			$route = URLRoute::getNotFoundRoute($uri);

			$route->parameter['message'] = $message;

			$result = $route->getDirect($this, $frameOpt);

			$this->output($result, $route);
		}
		catch (Exception $e)
		{
			$this->serveServerError("Internal Server Error", formatException($e), null);
		}

		exit();
	}

	/**
	 * @param string $message
	 * @param string|null $debugInfo
	 * @param PageFrameOptions|null $frameOpt
	 */
	private function serveServerError(string $message, $debugInfo, $frameOpt)
	{
		try
		{
			if ($frameOpt === null) $frameOpt = new PageFrameOptions();
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

	public function renderMarkdown(string $txt)
	{
		require_once 'parsedowncustom.php';
		$pd = new ParsedownCustom();
		return $pd->text($txt);
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