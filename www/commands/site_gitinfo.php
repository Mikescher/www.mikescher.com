<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['field'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$info = $SITE->gitStatus();

function printInfo($v) { if ($v === false) throw new Exception('Failed to query field'); else echo $v; }

$field = strtolower($API_OPTIONS['field']);

if ($field === 'branch')    { printInfo($info[0]);                         return; }
if ($field === 'head')      { printInfo($info[1]);                         return; }
if ($field === 'timestamp') { printInfo($info[3]);                         return; }
if ($field === 'origin')    { printInfo(str_replace(';', "\n", $info[4])); return; }
if ($field === 'message')   { printInfo($info[5]);                         return; }

$FRAME_OPTIONS->statuscode = 400;
echo 'Unknown field';

return;