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

function includeScriptOnce($script, $echo = true, $attr=false)
{
	global $REGISTERED_SCRIPTS;

	if ($echo)
	{
		if (in_array($script, $REGISTERED_SCRIPTS)) return false;
		$REGISTERED_SCRIPTS []= $script;
		echo "<script src=\"$script\" type=\"text/javascript\" $attr></script>";
		return true;
	}
	else
	{
		if (in_array($script, $REGISTERED_SCRIPTS)) return '';
		$REGISTERED_SCRIPTS []= $script;
		return "<script src=\"$script\" type=\"text/javascript\" $attr></script>";
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

function setLoginCookie($user, $pass)
{
	$expires = time() + (24*60*60); // 24h
	$hash = hash('sha256', $user . ';' . $pass);
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
		$auth = hash('sha256', $CONFIG['admin_username'] . ';' . $CONFIG['admin_password']);
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
 * @param  $file - file name to resize
 * @param  $string - The image data, as a string
 * @param  $width - new image width
 * @param  $height - new image height
 * @param  $proportional - keep image proportional, default is no
 * @param  $output - name of the new file (include path if needed)
 * @param  $quality - enter 1-100 (100 is best quality) default is 100
 * @return boolean|resource
 */
function smart_resize_image($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $quality = 100
) {

	if ( $height <= 0 && $width <= 0 ) return false;
	if ( $file === null && $string === null ) return false;

	# Setting defaults and meta
	$info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
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
		case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
		case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
		case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
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
		case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
		case IMAGETYPE_PNG:
			$quality = 9 - (int)((0.9*$quality)/10.0);
			imagepng($image_resized, $output, $quality);
			break;
		default: return false;
	}

	return true;
}