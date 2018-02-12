<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once (__DIR__ . '/../internals/database.php');

class AlephNoteStatistics
{
	public static function getTotalUserCount()
	{
		return Database::sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0');
	}

	public static function getUserCountFromLastVersion()
	{
		return Database::sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0 GROUP BY Version ORDER BY INET_ATON(Version) DESC LIMIT 1');
	}

	public static function getActiveUserCount($days)
	{
		return Database::sql_query_num('SELECT COUNT(*) FROM an_statslog WHERE NoteCount>0 AND LastChanged > NOW() - INTERVAL '.$days.' DAY');
	}

	public static function getAllActiveEntriesOrdered()
	{
		return Database::sql_query_assoc('SELECT * FROM an_statslog WHERE NoteCount>0 ORDER BY LastChanged DESC');
	}
}