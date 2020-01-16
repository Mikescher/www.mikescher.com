<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['name']))        { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['clientid']))    { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['version']))     { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['providerstr'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['providerid']))  { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['notecount']))   { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$nam = $API_OPTIONS['name'];
$cid = $API_OPTIONS['clientid'];
$ver = $API_OPTIONS['version'];
$prv = $API_OPTIONS['providerstr'];
$pid = $API_OPTIONS['providerid'];
$tnc = $API_OPTIONS['notecount'];

if ($nam !== 'AlephNote') print('{"success":false, "message":"Unknown AppName"}');


$SITE->modules->Database()->sql_exec_prep('INSERT INTO an_statslog (ClientID, Version, ProviderStr, ProviderID, NoteCount) VALUES (:cid1, :ver1, :prv1, :pid1, :tnc1) ON DUPLICATE KEY UPDATE Version=:ver2,ProviderStr=:prv2,ProviderID=:pid2,NoteCount=:tnc2',
[
	[':cid1', $cid, PDO::PARAM_STR],
	[':ver1', $ver, PDO::PARAM_STR],
	[':prv1', $prv, PDO::PARAM_STR],
	[':pid1', $pid, PDO::PARAM_STR],
	[':tnc1', $tnc, PDO::PARAM_INT],

	[':ver2', $ver, PDO::PARAM_STR],
	[':prv2', $prv, PDO::PARAM_STR],
	[':pid2', $pid, PDO::PARAM_STR],
	[':tnc2', $tnc, PDO::PARAM_INT],
]);

print('{"success":true}');

