<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php

if ($ROUTE->parameter['year'] === '')
{
	$year = array_last($SITE->modules->AdventOfCode()->listYears());
	$FRAME_OPTIONS->setForcedRedirect($SITE->modules->AdventOfCode()->getURLForYear($year));
	return;
}
else
{
	$year = intval($ROUTE->parameter['year']);

	if (in_array($year, $SITE->modules->AdventOfCode()->listYears()))
	{
		$FRAME_OPTIONS->setForcedRedirect($SITE->modules->AdventOfCode()->getURLForYear($year));
		return;
	}
	else
	{
		$FRAME_OPTIONS->setForced404('Advent of Code not found');
		return;
	}
}
?>
