<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;



if (!isset($API_OPTIONS['year']))       { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['nav']))        { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['linkheader'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['ajax']))       { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$year       = intval($API_OPTIONS['year']);
$shownav    = boolval($API_OPTIONS['nav']);
$linkheader = boolval($API_OPTIONS['linkheader']);
$ajax       = boolval($API_OPTIONS['ajax']);
$frameid    = strval($API_OPTIONS['frameid']);

echo $SITE->fragments->PanelAdventOfCodeCalendar($year, $shownav, $linkheader, $ajax, false, $frameid);
