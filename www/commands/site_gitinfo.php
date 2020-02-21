<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['field'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$field = strtolower($API_OPTIONS['field']);

if ($field === 'branch')    { echo exec('git rev-parse --abbrev-ref HEAD'); return; }
if ($field === 'head')      { echo exec('git rev-parse HEAD'); return; }
if ($field === 'timestamp') { echo (new DateTime(exec('git log -1 --format=%cd --date=iso')))->format('Y-m-d H:i:s'); return; }
if ($field === 'origin')    { echo exec('git config --get remote.origin.url'); return; }
if ($field === 'message')   { echo trim(shell_exec('git log -1 --format=%B')); return; }


$FRAME_OPTIONS->statuscode = 400;
echo 'Unknown field';

return;