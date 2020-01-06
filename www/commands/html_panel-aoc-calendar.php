<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/adventofcode.php');

global $PARAM_AOCCALENDAR;
$PARAM_AOCCALENDAR =
[
	'year'       => intval($_GET['year']),
	'nav'        => boolval($_GET['nav']),
	'linkheader' => boolval($_GET['linkheader']),
	'ajax'       => boolval($_GET['ajax']),
	'frame'      => false,
	'frameid'    => strval($_GET['frameid']),
];
require (__DIR__ . '/../fragments/panel_aoc_calendar.php');
