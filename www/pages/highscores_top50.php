<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';


$entries = $SITE->modules->Highscores()->getOrderedEntriesFromGame($ROUTE->parameter['gameid'], 50);

for ($i = 0; $i < count($entries); $i++)
{
	print($entries[$i]['POINTS'] . '||' . htmlspecialchars($entries[$i]['PLAYER']) . "\r\n");
}