<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

$CONFIG = require 'config.php';

$PDO = NULL;

function connect()
{
	global $CONFIG;
	global $PDO;

	$dsn = "mysql:host=" . $CONFIG['host'] . ";dbname=" . $CONFIG['database'] . ";charset=utf8";
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];

	$PDO = new PDO($dsn, $CONFIG['user'], $CONFIG['password'], $opt);
}