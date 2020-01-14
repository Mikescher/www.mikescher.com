<?php

require_once "website.php";

class URLRoute
{
	/** @var string */
	public $targetpath;

	/** @var string */
	public $full_url;

	/** @var array */
	public $parameter;

	/** @var int */
	public $needsAdminLogin;

	/** @var int */
	public $isAPI;

	public function __construct(string $target, string $url)
	{
		$this->targetpath = __DIR__ . '/../pages/' . $target;
		$this->full_url = $url;
		$this->parameter = [];
		$this->needsAdminLogin = false;
		$this->isAPI = false;
	}

	/**
	 * @param Website $app
	 * @return PageFrameOptions
	 */
	public function get(Website $app): PageFrameOptions
	{
		$pfo = new PageFrameOptions();

		$pfo->title = 'Mikescher.com'; // default title
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
	 * @param URLRoute $route
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getLoginRoute(URLRoute $route, string $requri): URLRoute
	{
		$r = new URLRoute('login.php', $requri);
		$r->parameter = [ 'redirect' => $route->full_url ];
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
		return $r;
	}
}