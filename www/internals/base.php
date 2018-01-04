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

	http_response_code($errorcode);

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

function convertCountryToFlag($country) {
	$country = trim(strtolower($country));

	if ($country === 'italy')       return '/data/images/flags/013-italy.svg';
	if ($country === 'china')       return '/data/images/flags/034-china.svg';
	if ($country === 'japan')       return '/data/images/flags/063-japan.svg';
	if ($country === 'un')          return '/data/images/flags/082-united-nations.svg';
	if ($country === 'south korea') return '/data/images/flags/094-south-korea.svg';
	if ($country === 'spain')       return '/data/images/flags/128-spain.svg';
	if ($country === 'norway')      return '/data/images/flags/143-norway.svg';
	if ($country === 'Czech')       return '/data/images/flags/149-czech-republic.svg';
	if ($country === 'germany')     return '/data/images/flags/162-germany.svg';
	if ($country === 'sweden')      return '/data/images/flags/184-sweden.svg';
	if ($country === 'france')      return '/data/images/flags/195-france.svg';
	if ($country === 'switzerland') return '/data/images/flags/205-switzerland.svg';
	if ($country === 'england')     return '/data/images/flags/216-england.svg';
	if ($country === 'usa')         return '/data/images/flags/226-united-states.svg';
	if ($country === 'america')     return '/data/images/flags/226-united-states.svg';
	if ($country === 'canada')      return '/data/images/flags/243-canada.svg';
	if ($country === 'russia')      return '/data/images/flags/248-russia.svg';
	if ($country === 'eu')          return '/data/images/flags/259-european-union.svg';
	if ($country === 'uk')          return '/data/images/flags/260-united-kingdom.svg';

	return null;
}

function convertLanguageToFlag($lang) {
	$lang = trim(strtolower($lang));

	if ($lang === 'italian')     return '/data/images/flags/013-italy.svg';
	if ($lang === 'english')     return '/data/images/flags/226-united-states.svg';
	if ($lang === 'french')      return '/data/images/flags/195-france.svg';
	if ($lang === 'german')      return '/data/images/flags/162-germany.svg';
	if ($lang === 'spanish')     return '/data/images/flags/128-spain.svg';

	return null;
}