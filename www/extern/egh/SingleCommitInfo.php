<?php

class SingleCommitInfo
{
	/* @var DateTime */
	public $Timestamp;

	/* @var string */
	public $SourcePlatform;

	/* @var string */
	public $SourceUser;

	/* @var string */
	public $SourceRepository;

	/**
	 * @param $ts DateTime
	 * @param $src string
	 * @param $usr string
	 * @param $repo string
	 */
	public function __construct($ts, $src, $usr, $repo) {
		$this->Timestamp        = $ts;
		$this->SourcePlatform   = $src;
		$this->SourceUser       = $usr;
		$this->SourceRepository = $repo;
	}


}