<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once (__DIR__ . '/../internals/database.php');

class Highscores
{
	public static function generateChecksum($rand, $player, $playerid, $points, $gamesalt)
	{
		if ($playerid >= 0)
			return md5($rand . $player . $playerid . $points . $gamesalt);
		else
			return md5($rand . $player . $points . $gamesalt);
	}

	public static function insert($gameid, $points, $name, $playerid, $check, $time, $ip)
	{
		return Database::sql_exec_prep('INSERT INTO ms4_highscoreentries (GAME_ID, POINTS, PLAYER, PLAYERID, CHECKSUM, TIMESTAMP, IP) VALUES (:gid, :p, :pn, :pid, :cs, :ts, :ip)',
			[
				[':gid', $gameid,   PDO::PARAM_INT],
				[':p',   $points,   PDO::PARAM_INT],
				[':pn',  $name,     PDO::PARAM_STR],
				[':pid', $playerid, PDO::PARAM_INT],
				[':cs',  $check,    PDO::PARAM_STR],
				[':ts',  $time,     PDO::PARAM_STR],
				[':ip',  $ip,       PDO::PARAM_STR],
			]);
	}

	public static function update($gameid, $points, $name, $playerid, $check, $time, $ip)
	{
		return Database::sql_exec_prep('UPDATE ms4_highscoreentries SET POINTS = :p, PLAYER = :pn, CHECKSUM = :cs, IP = :ip, TIMESTAMP = :ts WHERE GAME_ID = :gid AND PLAYERID = :pid',
			[
				[':gid', $gameid,   PDO::PARAM_INT],
				[':p',   $points,   PDO::PARAM_INT],
				[':pn',  $name,     PDO::PARAM_STR],
				[':pid', $playerid, PDO::PARAM_INT],
				[':cs',  $check,    PDO::PARAM_STR],
				[':ts',  $time,     PDO::PARAM_STR],
				[':ip',  $ip,       PDO::PARAM_STR],
			]);
	}

	public static function getGameByID($gameid)
	{
		return Database::sql_query_single_prep('SELECT * FROM ms4_highscoregames WHERE ID = :id',
			[
				[ ':id', $gameid, PDO::PARAM_INT ],
			]);
	}

	public static function getOrderedEntriesFromGame($gameid, $limit = null)
	{
		$sql = 'SELECT * FROM ms4_highscoreentries WHERE GAME_ID = :id ORDER BY POINTS DESC';
		if ($limit !== null) $sql .= " LIMIT $limit";

		return Database::sql_query_assoc_prep($sql,
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public static function getNewestEntriesFromGame($gameid, $limit = null)
	{
		$sql = 'SELECT * FROM ms4_highscoreentries WHERE GAME_ID = :id ORDER BY TIMESTAMP DESC';
		if ($limit !== null) $sql .= " LIMIT $limit";

		return Database::sql_query_assoc_prep($sql,
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public static function getEntryCountFromGame($gameid)
	{
		return Database::sql_query_num_prep('SELECT COUNT(*) FROM ms4_highscoreentries WHERE GAME_ID = :id',
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public static function getAllGames()
	{
		return Database::sql_query_assoc('SELECT * FROM ms4_highscoregames');
	}

	public static function getNextPlayerID($gameid)
	{
		return Database::sql_query_num_prep('SELECT MAX(PLAYERID)+1 AS NID FROM ms4_highscoreentries WHERE GAME_ID = :gid',
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public static function getSpecificScore($gameid, $playerid)
	{
		return Database::sql_query_single_prep('SELECT * FROM ms4_highscoreentries WHERE GAME_ID = :gid AND PLAYERID = :pid',
			[
				[ ':gid', $gameid,   PDO::PARAM_INT ],
				[ ':pid', $playerid, PDO::PARAM_INT ],
			]);
	}
}