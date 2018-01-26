<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$gameid = $OPTIONS['gameid'];
	$check  = $OPTIONS['check'];
	$name   = $OPTIONS['name'];
	$nameid = $OPTIONS['nameid'];
	$rand   = $OPTIONS['rand'];
	$points = $OPTIONS['points'];

	if (! is_numeric($gameid)) httpError(400, 'Invalid Request');
	if (! is_numeric($nameid)) httpError(400, 'Invalid Request');
	if (! is_numeric($points)) httpError(400, 'Invalid Request');

	$game = Highscores::getGameByID($OPTIONS['gameid']);
	if ($game == NULL) httpError(400, 'Invalid Request');

	$checksum_generated = Highscores::generateChecksum($rand, $name, $nameid, $points, $game['SALT']);
	if ($checksum_generated != $check) die('Nice try !');

	$old = Highscores::getSpecificScore($gameid, $nameid);

	if ($old == null)
	{
		Highscores::insert($gameid, $points, $name, $nameid, $check, date("Y-m-d H:m:s", time()), $_SERVER['REMOTE_ADDR']);
		echo 'ok.';
	}
	else 
	{
		Highscores::update($gameid, $points, $name, $nameid, $check, date("Y-m-d H:m:s", time()), $_SERVER['REMOTE_ADDR']);
		echo 'ok.';
	}
