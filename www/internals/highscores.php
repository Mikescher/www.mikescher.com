<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Highscores
{
	public static function generateChecksum($rand, $player, $playerid, $points, $gamesalt)
	{
		if ($playerid >= 0)
			return md5($rand . $player . $playerid . $points . $gamesalt);
		else
			return md5($rand . $player . $points . $gamesalt);
	}
}