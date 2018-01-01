<?php
require_once (__DIR__ . '/../internals/base.php');

global $PARAM_CODE;
global $PARAM_URL;
global $PARAM_INTERACTIVE;


$result = '';

$result .= '<div class="bce_code">' . "\n";
$result .= '	<div class="bce_code_data">' .htmlspecialchars($PARAM_CODE) . '</div>' . "\n";
$result .= '	<div class="bce_code_ctrl">' . "\n";
if ($PARAM_INTERACTIVE) {
	$result .= '		<div class="ctrl_btn_left">' . "\n";
	$result .= '			<div class="ctrl_btn">Start</div>' . "\n";
	$result .= '			<div class="ctrl_btn">Stop</div>' . "\n";
	$result .= '			<div class="ctrl_btn">Reset</div>' . "\n";
	$result .= '		</div>' . "\n";
}
if ($PARAM_URL !== '') {
	$result .= '		<div class="ctrl_btn_right">' . "\n";
	$result .= '			<a class="ctrl_btn" href="' .$PARAM_URL . '" download target="_blank">Download</a>' . "\n";
	$result .= '		</div>' . "\n";
}
$result .= '	</div>' . "\n";
$result .= '</div>' . "\n";

$result .= includeScriptOnce("/data/javascript/blogpost_bef93runner.js", false) . "\n";

return $result;