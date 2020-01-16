<?php


class PageFrameOptions
{
	/** @var string */
	public $raw;

	/** @var string */
	public $title = 'Mikescher.com';

	/** @var int */
	public $statuscode = 200;

	/**  @var bool */
	public $force_404 = false;

	/** @var string */
	public $force_404_message = '';

	/**  @var bool */
	public $force_redirect = false;

	/** @var string */
	public $force_redirect_url = '';

	/** @var string */
	public $frame = 'default_frame.php';

	/** @var string */
	public $contentType = null;

	/** @var string */
	public $activeHeader = null;

	/** @var string */
	public $canonical_url = null;

	/** @var string[] */
	public $contentCSSClasses = [ 'content-responsive' ];

	/** @var array */
	public $stylesheets = [];

	/** @var array */
	public $scripts = [];

	public function addStylesheet(string $url)
	{
		foreach ($this->stylesheets as $css) if ($css === $url) return;
		$this->stylesheets []= $url;
	}

	public function addScript(string $url, bool $defer = false)
	{
		foreach ($this->scripts as &$script)
		{
			if ($script[0] === $url)
			{
				if (!$defer && $script[1]) $script[1] = false; // upgrade from defered to immediate script
				return;
			}
		}

		$this->scripts []= [ $url, $defer ];
	}

	public function setForced404(string $err)
	{
		$this->force_404 = true;
		$this->force_404_message = $err;
	}

	public function setForcedRedirect(string $url)
	{
		$this->force_redirect = true;
		$this->force_redirect_url = $url;
	}
}