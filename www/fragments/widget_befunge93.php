<?php
require_once (__DIR__ . '/../internals/base.php');

global $PARAM_BEFUNGE93RUNNER;

$code        = $PARAM_BEFUNGE93RUNNER['code'];
$url         = $PARAM_BEFUNGE93RUNNER['url'];
$interactive = $PARAM_BEFUNGE93RUNNER['interactive'];
$initspeed   = $PARAM_BEFUNGE93RUNNER['speed'];
$editable    = $PARAM_BEFUNGE93RUNNER['editable'];

function fmtBef($str) {
	$str = htmlspecialchars($str);
	$str = str_replace("\r", "", $str);
	$str = join("\n", array_map(function($p){return rtrim($p);}, explode("\n", $str)));
	$str = str_replace(' ', '&nbsp;', $str);
	$str = nl2br($str);
	$str = str_replace("\r", '', $str);
	$str = str_replace("\n", '', $str);
	return $str;
}

$result = '';


if ($interactive) {
	$speed_attr = '';
	if (isset($initspeed) && $initspeed != NULL && $initspeed>0) $speed_attr = ' data-b93rnr_initialspeed="'.$initspeed.'" ';
	$code_attr  = '';
	$code_attr = 'data-b93rnr_code="' . base64_encode($code) . '"';

	$result .= '<div class="bce_code b93rnr_base" ' . $speed_attr . '>' . "\n";
	$result .= '	<div class="bce_code_data b93rnr_data" '.$code_attr.'>' . fmtBef($code) . '</div>' . "\n";
	$result .= '	<textarea class="bce_code_editarea b93rnr_editarea generic_collapsed"></textarea>' . "\n";
	$result .= '	<div class="bce_code_ctrl">' . "\n";
	$result .= '		<div class="ctrl_btn_left">' . "\n";
	$result .= '			<div class="ctrl_btn_group">' . "\n";
	$result .= '				<div class="ctrl_btn ctrl_btn_ll b93rnr_start">Start</div>' . "\n";
	$result .= '				<div class="ctrl_btn ctrl_btn_rr b93rnr_speed">??</div>' . "\n";
	$result .= '			</div>' . "\n";
	$result .= '			<div class="ctrl_btn b93rnr_pause ctrl_btn_disabled">Pause</div>' . "\n";
	$result .= '			<div class="ctrl_btn b93rnr_reset ctrl_btn_disabled">Reset</div>' . "\n";
	$result .= '		</div>' . "\n";
	$result .= '		<div class="ctrl_btn_right">' . "\n";
	if ($editable && $interactive) $result .= '			<div class="ctrl_btn b93rnr_edit">Edit</div>' . "\n";
	if ($url !== '') $result .= '			<a class="ctrl_btn" href="' . $url . '" download target="_blank">Download</a>' . "\n";
	$result .= '		</div>' . "\n";
	$result .= '	</div>' . "\n";
	$result .= '	<div class="bce_code_out b93rnr_outpanel generic_collapsed">' . "\n";
	$result .= '		<div class="bce_code_out_left">' . "\n";
	$result .= '			<b>Output:</b>' . "\n";
	$result .= '			<div class="bce_code_out_text b93rnr_output"></div>' . "\n";
	$result .= '		</div>' . "\n";
	$result .= '		<div class="bce_code_out_right">' . "\n";
	$result .= '			<span><b>Stack:</b>&nbsp;&nbsp;&nbsp;<i class="b93rnr_stacksize">(0)</i></span>' . "\n";
	$result .= '			<div class="bce_code_out_stack b93rnr_stack"></div>' . "\n";
	$result .= '		</div>' . "\n";
	$result .= '	</div>' . "\n";
	$result .= '</div>' . "\n";

	includeAdditionalScript("/data/javascript/blogpost_bef93runner.js");
}
else
{
	$result .= '<div class="bce_code">' . "\n";
	$result .= '	<div class="bce_code_data">' . fmtBef($code) . '</div>' . "\n";
	$result .= '	<div class="bce_code_ctrl">' . "\n";
	$result .= '		<div class="ctrl_btn_right">' . "\n";
	if ($url !== '') $result .= '			<a class="ctrl_btn" href="' . $url . '" download target="_blank">Download</a>' . "\n";
	$result .= '		</div>' . "\n";
	$result .= '	</div>' . "\n";
	$result .= '</div>' . "\n";
}

return $result;