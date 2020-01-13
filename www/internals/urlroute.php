<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once "URLRoute.php";

class URLRoute
{
	/** @var string */
	public $targetpath;

	/** @var string */
	public $full_url;

	/** @var array */
	public $parameter;

	/** @var int */
	public $minimal_access_rights;

	/** @var int */
	public $isAPI;

	public function __construct(string $target, string $url)
	{
		$this->targetpath = __DIR__ . '/../pages/' . $target;
		$this->full_url = $url;
		$this->parameter = [];
		$this->minimal_access_rights = 0;
		$this->isAPI = false;
	}

	/**
	 * @param VApp $app
	 * @return PageFrameOptions
	 */
	public function get(Website $app): PageFrameOptions
	{
		$pfo = new PageFrameOptions();

		$pfo->title = $app->config->verein_kurzel . " Orga"; // default title
		if ($this->isAPI)
		{
			$pfo->frame = 'no_frame.php';
			$pfo->contentType = 'application/json';
		}

		return $this->getDirect($app, $pfo);
	}

	/**
	 * @param Website $app
	 * @param PageFrameOptions $pfo
	 * @return PageFrameOptions
	 */
	public function getDirect(Website $app, PageFrameOptions $pfo): PageFrameOptions
	{
		@ob_end_clean();
		ob_start();

		global $ROUTE;
		global $FRAME_OPTIONS;
		global $APP;
		$ROUTE = $this;
		$FRAME_OPTIONS = $pfo;
		$APP = $app;

		/** @noinspection PhpIncludeInspection */
		require $this->targetpath;

		$FRAME_OPTIONS->raw = ob_get_clean();

		return $FRAME_OPTIONS;
	}

	/**
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getInsufficentRightsRoute(string $requri): URLRoute
	{
		$r = new URLRoute('errors/insufficent_rights.php', $requri);
		$r->parameter = [];
		$r->minimal_access_rights = 0;
		return $r;
	}

	/**
	 * @param URLRoute $route
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getLoginRoute(URLRoute $route, string $requri): URLRoute
	{
		$r = new URLRoute('login.php', $requri);
		$r->parameter = [ 'redirect' => $route->full_url ];
		$r->minimal_access_rights = 0;
		return $r;
	}

	/**
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getNotFoundRoute(string $requri): URLRoute
	{
		$r = new URLRoute('errors/not_found.php', $requri);
		$r->parameter = [];
		$r->minimal_access_rights = 0;
		return $r;
	}

	/**
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getServerErrorRoute(string $requri): URLRoute
	{
		$r = new URLRoute('errors/server_error.php', $requri);
		$r->parameter = [];
		$r->minimal_access_rights = 0;
		return $r;
	}
}