<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/programs.php');
	require_once (__DIR__ . '/../internals/updateslog.php');

	$name = $OPTIONS['name'];

	$updatedata = Programs::listUpdateData();

	if (! array_key_exists($name, $updatedata)) httpError(404, 'Invalid Request - [Name] not found');

	$data = $updatedata[$name];

	UpdatesLog::insert($name, $data['version']);

	print($name."<hr>".$data['version']."<hr>".$data['url']);