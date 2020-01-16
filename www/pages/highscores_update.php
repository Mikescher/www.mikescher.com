<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';


$gameid = $ROUTE->parameter['gameid'];
$check  = $ROUTE->parameter['check'];
$name   = $ROUTE->parameter['name'];
$nameid = $ROUTE->parameter['nameid'];
$rand   = $ROUTE->parameter['rand'];
$points = $ROUTE->parameter['points'];

if (! is_numeric($gameid)) { $FRAME_OPTIONS->forceResult(400, 'Invalid Request'); return; }
if (! is_numeric($nameid)) { $FRAME_OPTIONS->forceResult(400, 'Invalid Request'); return; }
if (! is_numeric($points)) { $FRAME_OPTIONS->forceResult(400, 'Invalid Request'); return; }

$game = $SITE->modules->Highscores()->getGameByID($ROUTE->parameter['gameid']);
if ($game == NULL) { $FRAME_OPTIONS->forceResult(400, 'Invalid Request'); return; }

$checksum_generated = $SITE->modules->Highscores()->generateChecksum($rand, $name, $nameid, $points, $game['SALT']);
if ($checksum_generated != $check) die('Nice try !');

$old = $SITE->modules->Highscores()->getSpecificScore($gameid, $nameid);

if ($old == null)
{
	$SITE->modules->Highscores()->insert($gameid, $points, $name, $nameid, $check, date("Y-m-d H:m:s", time()), $_SERVER['REMOTE_ADDR']);
	echo 'ok.';
}
else
{
	$SITE->modules->Highscores()->update($gameid, $points, $name, $nameid, $check, date("Y-m-d H:m:s", time()), $_SERVER['REMOTE_ADDR']);
	echo 'ok.';
}
