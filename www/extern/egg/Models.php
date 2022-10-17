<?php

class Repository
{
	/** @var int */
	public $ID;

	/** @var string */
	public $URL;

	/** @var string */
	public $Name;

	/** @var string */
	public $Source;

	/** @var string */
	public $LastUpdate; // UTC

	/** @var string */
	public $LastChange; // UTC
}

class Branch
{
	/** @var int */
	public $ID;

	/** @var string */
	public $Name;

	/** @var Repository */
	public $Repo;

	/** @var string|null */
	public $Head;

	/** @var string|null */
	public $HeadFromAPI = null;

	/** @var string */
	public $LastUpdate; // UTC

	/** @var string */
	public $LastChange; // UTC
}

class Commit
{
	/** @var int */
	public $ID;

	/** @var Repository */
	public $Repo;

	/** @var Branch */
	public $Branch;

	/** @var string */
	public $Hash;

	/** @var string */
	public $AuthorName;

	/** @var string */
	public $AuthorEmail;

	/** @var string */
	public $CommitterName;

	/** @var string */
	public $CommitterEmail;

	/** @var string */
	public $Message;

	/** @var string */
	public $Date; // UTC

	/** @var string[] */
	public $Parents;

}