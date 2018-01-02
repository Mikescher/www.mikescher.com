<?php
require_once (__DIR__ . '/../internals/base.php');

global $PARAM_CODE;
global $PARAM_URL;
global $PARAM_INTERACTIVE;

function fmtBef($str) {
	$str = htmlspecialchars($str);
	$str = str_replace("\r\n", "\n", $str);
	$str = join("\n", array_map(function($p){return rtrim($p);}, explode("\n", $str)));
	$str = str_replace(' ', '&nbsp;', $str);
	$str = nl2br($str);
	$str = str_replace("\r", '', $str);
	$str = str_replace("\n", '', $str);
	return $str;
}

$result = '';

if ($PARAM_INTERACTIVE) {
	$result .= '<div class="bce_code b93rnr_base">' . "\n";
	$result .= '	<div class="bce_code_data b93rnr_data" data-befcode="' . base64_encode($PARAM_CODE) . '">' . fmtBef($PARAM_CODE) . '</div>' . "\n";
	$result .= '	<div class="bce_code_ctrl">' . "\n";
	$result .= '		<div class="ctrl_btn_left">' . "\n";
	$result .= '			<div class="ctrl_btn b93rnr_start">Start</div>' . "\n";
	$result .= '			<div class="ctrl_btn b93rnr_pause ctrl_btn_disabled">Pause</div>' . "\n";
	$result .= '			<div class="ctrl_btn b93rnr_reset ctrl_btn_disabled">Reset</div>' . "\n";
	$result .= '		</div>' . "\n";
	if ($PARAM_URL !== '') {
		$result .= '		<div class="ctrl_btn_right">' . "\n";
		$result .= '			<a class="ctrl_btn" href="' . $PARAM_URL . '" download target="_blank">Download</a>' . "\n";
		$result .= '		</div>' . "\n";
	}
	$result .= '	</div>' . "\n";
	$result .= '	<div class="bce_code_out b93rnr_outpanel b93rnr_outpanel_hidden">' . "\n";
	$result .= '		<div class="bce_code_out_text b93rnr_output"></div>' . "\n";
	$result .= '		<div class="bce_code_out_stack b93rnr_stack"></div>' . "\n";
	$result .= '	</div>' . "\n";
	$result .= '</div>' . "\n";

	$result .= includeScriptOnce("/data/javascript/blogpost_bef93runner.js", false) . "\n";
}
else
{
	$result .= '<div class="bce_code">' . "\n";
	$result .= '	<div class="bce_code_data">' . fmtBef($PARAM_CODE) . '</div>' . "\n";
	$result .= '	<div class="bce_code_ctrl">' . "\n";
	if ($PARAM_URL !== '') {
		$result .= '		<div class="ctrl_btn_right">' . "\n";
		$result .= '			<a class="ctrl_btn" href="' . $PARAM_URL . '" download target="_blank">Download</a>' . "\n";
		$result .= '		</div>' . "\n";
	}
	$result .= '	</div>' . "\n";
	$result .= '</div>' . "\n";
}

return $result;