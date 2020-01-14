<?php


class PageFrameOptions
{
	/** @var string */
	public $raw;

	/** @var string */
	public $title = '';

	/** @var int */
	public $statuscode = 200;

	/**  @var bool */
	public $force_404 = false;

	/** @var string */
	public $force_404_message = '';

	/** @var string */
	public $frame = 'default_frame.php';

	/** @var string */
	public $contentType = null;
}