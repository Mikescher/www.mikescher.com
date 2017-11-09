<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$gameid = $OPTIONS['gameid'];
	$check  = $OPTIONS['check'];
	$name   = $OPTIONS['name'];
	$rand   = $OPTIONS['rand'];
	$points = $OPTIONS['points'];

	if (! is_numeric($gameid)) httpError(400, 'Invalid Request');
	if (! is_numeric($points)) httpError(400, 'Invalid Request');

	$game = Database::sql_query_single_prep('SELECT * FROM ms4_highscoregames WHERE ID = :id', 
	[
		[ ':id', $OPTIONS['gameid'], PDO::PARAM_INT ],
	]);
	if ($game == NULL) httpError(400, 'Invalid Request');

	$checksum_generated = Highscores::generateChecksum($rand, $name, -1, $points, $game['SALT']);
	if ($checksum_generated != $check) die('Nice try !');

	Database::sql_exec_prep('INSERT INTO ms4_highscoreentries (GAME_ID, POINTS, PLAYER, PLAYERID, CHECKSUM, TIMESTAMP, IP) VALUES (:gid, :p, :pn, :pid, :cs, :ts, :ip)',
	[
		[':gid', $gameid, PDO::PARAM_INT],
		[':p',   $points, PDO::PARAM_INT],
		[':pn',  $name, PDO::PARAM_STR],
		[':pid', -1, PDO::PARAM_INT],
		[':cs',  $check, PDO::PARAM_STR],
		[':ts',  time(), PDO::PARAM_STR],
		[':ip',  $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR],
	]);

	echo 'ok.';