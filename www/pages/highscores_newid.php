<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$newid = Highscores::getNextPlayerID($OPTIONS['gameid']);
	
	if ($newid < 1024) $newid = 1024;

	print $newid;