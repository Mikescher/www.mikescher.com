<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$entries = Database::sql_query_single_prep('SELECT * FROM ms4_highscoreentries WHERE GAME_ID = :id ORDER BY POINTS DESC LIMIT 50', 
	[
		[ ':id', $OPTIONS['gameid'], PDO::PARAM_INT ]
	]);

for ($i = 0; $i < count($entries); $i++)
{
	print($entries[$i]['POINTS'] . '||' . htmlentities($entries[$i]['PLAYER']) . "\r\n");
}