<?php


class EGGException extends Exception
{
	public $egg_message;

	public function __construct($message)
	{
		parent::__construct($message);

		$this->egg_message = $message;
	}
}