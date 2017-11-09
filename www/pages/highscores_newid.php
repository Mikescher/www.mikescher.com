<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$newid = Database::sql_query_num_prep('SELECT MAX(PLAYERID)+1 AS NID FROM ms4_highscoreentries WHERE GAME_ID = :gid', 
	[
		[ ':id', $OPTIONS['gameid'], PDO::PARAM_INT ]
	]);
	
	if ($newid < 1024) $newid = 1024;

	print $newid;