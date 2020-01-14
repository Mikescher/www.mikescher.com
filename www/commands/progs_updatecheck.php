<?php

global $API_OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/programs.php');
require_once (__DIR__ . '/../internals/updateslog.php');

if (!isset($API_OPTIONS['name'])) httpDie(400, "Wrong parameters.");

$name = $API_OPTIONS['name'];

$updatedata = UpdatesLog::listUpdateData();

if (!array_key_exists($name, $updatedata)) httpError(404, 'Invalid Request - [Name] not found');

$data = $updatedata[$name];

UpdatesLog::insert($name, $data['version']);

print($name."<hr>".$data['version']."<hr>".$data['url']);
