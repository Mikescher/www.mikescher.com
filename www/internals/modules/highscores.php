<?php

class Highscores implements IWebsiteModule
{
	/** @var Website */
	private $site;

	public function __construct(Website $site)
	{
		$this->site = $site;
	}

	public function generateChecksum($rand, $player, $playerid, $points, $gamesalt)
	{
		if ($playerid >= 0)
			return md5($rand . $player . $playerid . $points . $gamesalt);
		else
			return md5($rand . $player . $points . $gamesalt);
	}

	public function insert($gameid, $points, $name, $playerid, $check, $time, $ip)
	{
		return $this->site->modules->Database()->sql_exec_prep('INSERT INTO highscoreentries (GAME_ID, POINTS, PLAYER, PLAYERID, CHECKSUM, TIMESTAMP, IP) VALUES (:gid, :p, :pn, :pid, :cs, :ts, :ip)',
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

	public function update($gameid, $points, $name, $playerid, $check, $time, $ip)
	{
		return $this->site->modules->Database()->sql_exec_prep('UPDATE highscoreentries SET POINTS = :p, PLAYER = :pn, CHECKSUM = :cs, IP = :ip, TIMESTAMP = :ts WHERE GAME_ID = :gid AND PLAYERID = :pid',
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

	public function getGameByID($gameid)
	{
		return $this->site->modules->Database()->sql_query_single_prep('SELECT * FROM highscoregames WHERE ID = :id',
			[
				[ ':id', $gameid, PDO::PARAM_INT ],
			]);
	}

	public function getOrderedEntriesFromGame($gameid, $limit = null)
	{
		$sql = 'SELECT * FROM highscoreentries WHERE GAME_ID = :id ORDER BY POINTS DESC';
		if ($limit !== null) $sql .= " LIMIT $limit";

		return $this->site->modules->Database()->sql_query_assoc_prep($sql,
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public function getNewestEntriesFromGame($gameid, $limit = null)
	{
		$sql = 'SELECT * FROM highscoreentries WHERE GAME_ID = :id ORDER BY TIMESTAMP DESC';
		if ($limit !== null) $sql .= " LIMIT $limit";

		return $this->site->modules->Database()->sql_query_assoc_prep($sql,
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public function getEntryCountFromGame($gameid)
	{
		return $this->site->modules->Database()->sql_query_num_prep('SELECT COUNT(*) FROM highscoreentries WHERE GAME_ID = :id',
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public function getAllGames()
	{
		return $this->site->modules->Database()->sql_query_assoc('SELECT * FROM highscoregames');
	}

	public function getNextPlayerID($gameid)
	{
		return $this->site->modules->Database()->sql_query_num_prep('SELECT MAX(PLAYERID)+1 AS NID FROM highscoreentries WHERE GAME_ID = :gid',
			[
				[ ':id', $gameid, PDO::PARAM_INT ]
			]);
	}

	public function getSpecificScore($gameid, $playerid)
	{
		return $this->site->modules->Database()->sql_query_single_prep('SELECT * FROM highscoreentries WHERE GAME_ID = :gid AND PLAYERID = :pid',
			[
				[ ':gid', $gameid,   PDO::PARAM_INT ],
				[ ':pid', $playerid, PDO::PARAM_INT ],
			]);
	}

	public function checkConsistency()
	{
		return ['result'=>'ok', 'message' => ''];
	}
}