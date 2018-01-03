<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

global $CONFIG;
$CONFIG = require 'config.php';

global $CSS_BASE;
$CSS_BASE = ($CONFIG['prod']) ? ('/data/css/styles.min.css') : ('/data/css/styles.css');

global $REGISTERED_SCRIPTS;
$REGISTERED_SCRIPTS = [];

function InitPHP() {

	set_error_handler("exception_error_handler"); // errors as exceptions for global catch

	ob_start(); // buffer outpt so it can be discarded in httpError

}

function exception_error_handler($severity, $message, $file, $line) {
	if (!(error_reporting() & $severity)) {
		// This error code is not included in error_reporting
		return;
	}
	throw new ErrorException($message, 0, $severity, $file, $line);
}

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
	ob_clean();

	global $OPTIONS;
	$OPTIONS = [ 'code' => $errorcode, 'message' => $message ];
	require (__DIR__ . '/../pages/errorview.php');
	die();
}

function destructiveUrlEncode($str) {
	$str = str_replace(' ', '_', $str);
	$str = str_replace('+', '_', $str);
	$str = str_replace('.', '', $str);
	return urlencode($str);
}

function formatMilliseconds($millis)
{
	if ($millis < 1000)
	{
		return $millis . 'ms';
	}
	else if ($millis < 10 * 1000)
	{
		return number_format($millis / (1000), 2) . 's';
	}
	else if ($millis < 60 * 1000)
	{
		return floor($millis / (1000)) . 's';
	}
	else if ($millis < 10 * 60 * 1000)
	{
		return floor($millis / (60 * 1000)) . 'min ' . floor(($millis % (60 * 1000)) / 1000) . 's';
	}
	else if ($millis < 60 * 60 * 1000)
	{
		return floor($millis / (60 * 1000)) . 'min';
	}
	else if ($millis < 10 * 60 * 60 * 1000)
	{
		return number_format($millis / (60 * 60 * 1000), 2) . ' hours';
	}
	else
	{
		return floor($millis / (60 * 60 * 1000)) . ' hours';
	}
}

function includeScriptOnce($script, $echo = true)
{
	global $REGISTERED_SCRIPTS;

	if ($echo)
	{
		if (in_array($script, $REGISTERED_SCRIPTS)) return false;
		$REGISTERED_SCRIPTS []= $script;
		echo "<script src=\"$script\" type=\"text/javascript\"></script>";
		return true;
	}
	else
	{
		if (in_array($script, $REGISTERED_SCRIPTS)) return '';
		$REGISTERED_SCRIPTS []= $script;
		return "<script src=\"$script\" type=\"text/javascript\"></script>";
	}
}

function printCSS() {
	global $CSS_BASE;
	echo   '<link rel="stylesheet" href="' . $CSS_BASE . '"/>';
}

function isProd() {
	global $CONFIG;
	return $CONFIG['prod'];
}