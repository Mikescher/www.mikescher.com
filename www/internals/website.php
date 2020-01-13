<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once 'ruleengine.php';
require_once 'urlroute.php';
require_once 'pageframeoptions.php';

class Website
{
	/** @var Website */
	private static $instance;

	/** @var array */
	private $config;

	public function init()
	{
		set_error_handler("exception_error_handler"); // errors as exceptions for global catch

		try
		{
			$this->config = require (__DIR__ . "/config.php");
		}
		catch (exception $e)
		{
			$this->serveServerError("config.php not found", formatException($e), null);
		}

		try
		{
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

	public static function getInstance()
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

	/**
	 * @param PageFrameOptions $pfo
	 * @param URLRoute $route
	 */
	private function output(PageFrameOptions $pfo, URLRoute $route)
	{
		if ($pfo->contentType !== null) header('Content-Type: ' . $pfo->contentType);
		http_response_code($pfo->statuscode);

		global $ROUTE;
		global $FRAME_OPTIONS;
		global $APP;
		$ROUTE = $route;
		$FRAME_OPTIONS = $pfo;
		$APP = $this;

		/** @noinspection PhpIncludeInspection */
		require __DIR__ . '/../pages/frame/' . $FRAME_OPTIONS->frame;
	}

	/**
	 * @return bool
	 */
	public function isProd()
	{
		if ($this->config == null) return true;
		return $this->config['prod'];
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