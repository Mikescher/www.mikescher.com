<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['name'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$name = $API_OPTIONS['name'];

$updatedata = $SITE->modules->UpdatesLog()->listUpdateData();

if (!array_key_exists($name, $updatedata)) { $FRAME_OPTIONS->forceResult(404, 'Invalid Request - [Name] not found'); return; }

$data = $updatedata[$name];

$SITE->modules->UpdatesLog()->insert($name, $data['version']);

print($name."<hr>".$data['version']."<hr>".$data['url']);
