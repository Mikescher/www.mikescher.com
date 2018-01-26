<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$entries = Highscores::getOrderedEntriesFromGame($OPTIONS['gameid'], 50);

for ($i = 0; $i < count($entries); $i++)
{
	print($entries[$i]['POINTS'] . '||' . htmlspecialchars($entries[$i]['PLAYER']) . "\r\n");
}