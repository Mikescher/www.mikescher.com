<?php

require_once 'website.php';

class AlephNoteStatistics
{
	/** @var Website */
	private $site;

	public function __construct(Website $site)
	{
		$this->site = $site;

		$site->Database();
	}

	public function getTotalUserCount()
	{
		return $this->site->Database()->sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0');
	}

	public function getUserCountFromLastVersion()
	{
		return $this->site->Database()->sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0 GROUP BY Version ORDER BY INET_ATON(Version) DESC LIMIT 1');
	}

	public function getActiveUserCount($days)
	{
		return $this->site->Database()->sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0 AND LastChanged > NOW() - INTERVAL '.$days.' DAY');
	}

	public function getAllActiveEntriesOrdered()
	{
		return $this->site->Database()->sql_query_assoc('SELECT * FROM an_statslog WHERE NoteCount>0 ORDER BY LastChanged DESC');
	}
}