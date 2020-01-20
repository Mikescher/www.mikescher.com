<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';


$newid = $SITE->modules->Highscores()->getNextPlayerID($ROUTE->parameter['gameid']);

if ($newid < 1024) $newid = 1024;

print $newid;