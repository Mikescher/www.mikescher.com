<?php

require_once 'SingleCommitInfo.php';

class ConnectionGitea
{
	/* @var string */
	private $url;

	/* @var string */
	private $owner;

	/**
	 * @param $owner ExtendedGitGraph
	 */
	public function __construct($owner) {
		$this->owner = $owner;
	}

	public function setURL($giteaurl) {
		$this->url = $giteaurl;
	}

	/* @return SingleCommitInfo[] */
	public function getDataUser($cfg)
	{
		$result = []; //TODO

		return $result;
	}

	/* @return SingleCommitInfo[] */
	public function getDataRepository($cfg)
	{
		$result = []; //TODO

		return $result;
	}
}