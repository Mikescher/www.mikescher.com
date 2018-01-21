<?php

class EGHRemoteConfig
{
	/* @var string|null */
	public $Type;
	/* @var string|null */
	public $URL;
	/* @var string|null */
	public $Author;
	/* @var string|null */
	public $Param;

	/**
	 * @param $typ string|null
	 * @param $url string|null
	 * @param $usr string|null
	 * @param $param string|null
	 */
	public function __construct($typ, $url, $usr, $param) {
		$this->Type     = $typ;
		$this->URL      = $url;
		$this->Author   = $usr;
		$this->Param    = $param;
	}

}