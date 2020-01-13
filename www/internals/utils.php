<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

global $CONFIG;
$CONFIG = require 'config.php';

global $CSS_BASE;
$CSS_BASE = ($CONFIG['prod']) ? ('/data/css/styles.min.css') : ('/data/css/styles.css');

global $ADDITIONAL_SCRIPTS;
global $ADDITIONAL_STYLESHEETS;
$ADDITIONAL_SCRIPTS     = [];
$ADDITIONAL_STYLESHEETS = [];

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

function httpDie($errorcode, $message)
{
	ob_flush();
	http_response_code($errorcode);
	die($message);

}

function destructiveUrlEncode($str) {
	$str = str_replace(' ', '_', $str);
	$str = str_replace('+', '_', $str);
	$str = str_replace(':', '_', $str);
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

function includeAdditionalScript($script, $attr='', $printImmediately = false) {
	global $ADDITIONAL_SCRIPTS;

	if (in_array($script, $ADDITIONAL_SCRIPTS)) return false;

	if ($printImmediately) {
		$ADDITIONAL_SCRIPTS[$script] = ['src' => $script, 'attr' => $attr, 'consumed' => true];
		echo '<script src="'.$script.'" type="text/javascript" '.$attr.'></script>';
		return true;
	} else {
		$ADDITIONAL_SCRIPTS[$script] = ['src' => $script, 'attr' => $attr, 'consumed' => false];
		return true;
	}
}

function includeAdditionalStylesheet($sheet, $attr='', $printImmediately = false) {
	global $ADDITIONAL_STYLESHEETS;

	if (in_array($sheet, $ADDITIONAL_STYLESHEETS)) return false;

	if ($printImmediately) {
		$ADDITIONAL_STYLESHEETS[$sheet] = ['src' => $sheet, 'attr' => $attr, 'consumed' => true];
		echo '<link rel="stylesheet" href="' . $sheet . '" '.$attr.'/>';
		return true;
	} else {
		$ADDITIONAL_STYLESHEETS[$sheet] = ['src' => $sheet, 'attr' => $attr, 'consumed' => false];
		return true;
	}
}

function printHeaderCSS() {
	global $CSS_BASE;
	includeAdditionalStylesheet($CSS_BASE, '', true);
}

function printAdditionalScripts()  {
	global $ADDITIONAL_SCRIPTS;

	foreach ($ADDITIONAL_SCRIPTS as $d) {
		if ($d['consumed']) continue;
		echo '<script src="' . $d['src'] . '" type="text/javascript" ' . $d['attr'] . '></script>';
		$d['consumed'] = true;
	}
}

function printAdditionalStylesheets()  {
	global $ADDITIONAL_STYLESHEETS;

	foreach ($ADDITIONAL_STYLESHEETS as $d) {
		if ($d['consumed']) continue;
		echo '<link rel="stylesheet" href="' . $d['src'] . '" ' . $d['attr'] . '/>';
		$d['consumed'] = true;
	}
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

function setLoginCookie($user, $pass)
{
	$expires = time() + (24*60*60); // 24h
	$hash = hash('sha256', $user . ';' . $pass . ';' . gmdate('Y-m-d'));
	setcookie('mikescher_auth', $hash, $expires);
}

function isLoggedInByCookie()
{
	static $_loginCache = null;
	if ($_loginCache !== null) return $_loginCache;

	global $CONFIG;
	if (key_exists('mikescher_auth', $_COOKIE))
	{
		if (strlen($_COOKIE['mikescher_auth']) !== 64) return $_loginCache = false;
		$auth = hash('sha256', $CONFIG['admin_username'] . ';' . $CONFIG['admin_password'] . ';' . gmdate('Y-m-d'));
		if ($auth === $_COOKIE['mikescher_auth']) return $_loginCache = true;
	}

	return $_loginCache = false;
}

function clearLoginCookie()
{
	setcookie("mikescher_auth", "", time()+30);
}

/**
 * easy image resize function
 * @author http://www.nimrodstech.com/php-image-resize/
 * @param  string $file - file name to resize
 * @param  int $width - new image width
 * @param  int $height - new image height
 * @param  boolean $proportional - keep image proportional, default is no
 * @param  string $output - name of the new file (include path if needed)
 * @return boolean|resource
 */
function smart_resize_image($file, $width = 0, $height = 0, $proportional, $output)
{
	if ( $height <= 0 && $width <= 0 ) return false;
	if ( $file === null) return false;

	# Setting defaults and meta
	$info                         = getimagesize($file);
	$image                        = '';
	$final_width                  = 0;
	$final_height                 = 0;
	list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;

	# Calculating proportionality
	if ($proportional) {
		if      ($width  == 0)  $factor = $height/$height_old;
		elseif  ($height == 0)  $factor = $width/$width_old;
		else                    $factor = min( $width / $width_old, $height / $height_old );

		$final_width  = round( $width_old * $factor );
		$final_height = round( $height_old * $factor );
	}
	else {
		$final_width = ( $width <= 0 ) ? $width_old : $width;
		$final_height = ( $height <= 0 ) ? $height_old : $height;
		$widthX = $width_old / $width;
		$heightX = $height_old / $height;

		$x = min($widthX, $heightX);
		$cropWidth = ($width_old - $width * $x) / 2;
		$cropHeight = ($height_old - $height * $x) / 2;
	}

	# Loading image to memory according to type
	switch ( $info[2] ) {
		case IMAGETYPE_JPEG:  $image = imagecreatefromjpeg($file); break;
		case IMAGETYPE_GIF:   $image = imagecreatefromgif($file);  break;
		case IMAGETYPE_PNG:   $image = imagecreatefrompng($file);  break;
		default: return false;
	}


	# This is the resizing/resampling/transparency-preserving magic
	$image_resized = imagecreatetruecolor( $final_width, $final_height );
	if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
		$transparency = imagecolortransparent($image);
		$palletsize = imagecolorstotal($image);

		if ($transparency >= 0 && $transparency < $palletsize) {
			$transparent_color  = imagecolorsforindex($image, $transparency);
			$transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($image_resized, 0, 0, $transparency);
			imagecolortransparent($image_resized, $transparency);
		}
		elseif ($info[2] == IMAGETYPE_PNG) {
			imagealphablending($image_resized, false);
			$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
			imagefill($image_resized, 0, 0, $color);
			imagesavealpha($image_resized, true);
		}
	}
	imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);

	# Preparing a method of providing result
	switch ( strtolower($output) ) {
		case 'browser':
			$mime = image_type_to_mime_type($info[2]);
			header("Content-type: $mime");
			$output = NULL;
			break;
		case 'file':
			$output = $file;
			break;
		case 'return':
			return $image_resized;
			break;
		default:
			break;
	}

	# Writing image according to type to the output destination and image quality
	switch ( $info[2] ) {
		case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
		case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, 100);   break;
		case IMAGETYPE_PNG:
			$quality = 9 - (int)((0.9*100)/10.0);
			imagepng($image_resized, $output, $quality);
			break;
		default: return false;
	}

	return true;
}

/**
 * @param  string $file - file name to resize
 * @param  int $width - new image width
 * @param  int $height - new image height
 * @param  string $output - name of the new file (include path if needed)
 */
function magick_resize_image($file, $width, $height, $output)
{
	list($width_old, $height_old) = getimagesize($file);

	if      ($width  == 0)  $factor = $height/$height_old;
	elseif  ($height == 0)  $factor = $width/$width_old;
	else                    $factor = min( $width / $width_old, $height / $height_old );

	$final_width  = round( $width_old * $factor );
	$final_height = round( $height_old * $factor );

	$cmd = 'convert "' . $file . '" -strip -resize ' . $final_width . 'x' . $final_height . ' "' . $output . '"';

	shell_exec($cmd);
}

function sendMail($subject, $content, $to, $from) {
	mail($to, $subject, $content, 'From: ' . $from);
}

function ParamServerOrUndef($idx) {
	return isset($_SERVER[$idx]) ? $_SERVER[$idx] : 'NOT_SET';
}

/**
 * @param Exception $e
 */
function sendExceptionMail($e)
{
	try	{
		$subject = "Server has encountered an Error at " . date("Y-m-d H:i:s") . "] ";

		$content = "";

		$content .= 'HTTP_HOST: '            . ParamServerOrUndef('HTTP_HOST')            . "\n";
		$content .= 'REQUEST_URI: '          . ParamServerOrUndef('REQUEST_URI')          . "\n";
		$content .= 'TIME: '                 . date('Y-m-d H:i:s')                        . "\n";
		$content .= 'REMOTE_ADDR: '          . ParamServerOrUndef('REMOTE_ADDR')          . "\n";
		$content .= 'HTTP_X_FORWARDED_FOR: ' . ParamServerOrUndef('HTTP_X_FORWARDED_FOR') . "\n";
		$content .= 'HTTP_USER_AGENT: '      . ParamServerOrUndef('HTTP_USER_AGENT')      . "\n";
		$content .= 'MESSAGE:'               . "\n" . $e->getMessage()                    . "\n";
		$content .= 'CODE:'                  . "\n" . $e->getCode()                       . "\n";
		$content .= 'TRACE:'                 . "\n" . $e->getTraceAsString()              . "\n";
		$content .= '$_GET:'                 . "\n" . print_r($_GET, true)                . "\n";
		$content .= '$_POST:'                . "\n" . print_r($_POST, true)               . "\n";
		$content .= '$_FILES:'               . "\n" . print_r($_FILES, true)              . "\n";

		sendMail($subject, $content, 'virtualadmin@mikescher.de', 'webserver-error@mikescher.com');
	}
	catch (Exception $e)
	{
		//
	}
}

function get_client_ip() {
	if (getenv('HTTP_CLIENT_IP')) return getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR')) return getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED')) return getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR')) return getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED')) return getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR')) return getenv('REMOTE_ADDR');
	else if (isset($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED'])) return $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) return $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED'])) return $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR'])) return $_SERVER['REMOTE_ADDR'];
	else return 'UNKNOWN';
}

function getRandomToken($length = 32)
{
	try
	{
		if(!isset($length) || intval($length) <= 8 ) $length = 32;

		if (function_exists('random_bytes')) return bin2hex(random_bytes($length));
		if (function_exists('mcrypt_create_iv')) return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
		if (function_exists('openssl_random_pseudo_bytes')) return bin2hex(openssl_random_pseudo_bytes($length));
	}
	catch (Exception $e) { throw new InvalidArgumentException($e); }

	throw new InvalidArgumentException("No random");
}