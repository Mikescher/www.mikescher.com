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

	public function __construct(string $target, string $url)
	{
		$this->targetpath = __DIR__ . '/../pages/' . $target;
		$this->full_url = $url;
		$this->parameter = [];
		$this->needsAdminLogin = false;
	}

	/**
	 * @param Website $site
	 * @return PageFrameOptions
	 */
	public function get(Website $site): PageFrameOptions
	{
		$pfo = new PageFrameOptions();

		$pfo->addStylesheet($site->isProd() ? ('/data/css/styles.min.css') : ('/data/css/styles.css'));

		return $this->getDirect($site, $pfo);
	}

	/**
	 * @param Website $site
	 * @param PageFrameOptions $pfo
	 * @return PageFrameOptions
	 */
	public function getDirect(Website $site, PageFrameOptions $pfo): PageFrameOptions
	{
		try
		{
			ob_start();

			global $ROUTE;
			global $FRAME_OPTIONS;
			global $SITE;
			$ROUTE = $this;
			$FRAME_OPTIONS = $pfo;
			$SITE = $site;

			/** @noinspection PhpIncludeInspection */
			require $this->targetpath;

			$FRAME_OPTIONS->raw = ob_get_contents();

			return $FRAME_OPTIONS;
		}
		finally
		{
			ob_end_clean();
		}
	}

	/**
	 * @param URLRoute $route
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getLoginRoute(URLRoute $route, string $requri): URLRoute
	{
		$r = new URLRoute('login.php', $requri);
		$r->parameter = [ 'login_target' => $route->full_url ];
		return $r;
	}

	/**
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getNotFoundRoute(string $requri): URLRoute
	{
		$r = new URLRoute('error_notfound.php', $requri);
		$r->parameter = [];
		return $r;
	}

	/**
	 * @param string $requri
	 * @return URLRoute
	 */
	public static function getServerErrorRoute(string $requri): URLRoute
	{
		$r = new URLRoute('error_servererror.php', $requri);
		$r->parameter = [];
		return $r;
	}
}