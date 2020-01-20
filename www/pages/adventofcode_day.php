<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php

$year = intval($ROUTE->parameter['year']);
$day  = intval($ROUTE->parameter['day']);

if ($SITE->modules->AdventOfCode()->getSingleDay($year, $day) === null)
{
	$FRAME_OPTIONS->setForced404('Advent of Code not found');
	return;
}

$FRAME_OPTIONS->setForcedRedirect($SITE->modules->AdventOfCode()->getSingleDay($year, $day)['url']);
?>
