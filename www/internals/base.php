<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

global $CONFIG;
$CONFIG = require 'config.php';

function startsWith($haystack, $needle)
{
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	return $length === 0 || (substr($haystack, -$length) === $needle);
}

function httpError($errorcode, $message)
{
	die($message);//TODO errorcode
}