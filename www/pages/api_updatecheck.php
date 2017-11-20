<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/programs.php');

	$name = $OPTIONS['name'];

	$updatedata = listUpdateData();

	if (! array_key_exists($name, $updatedata)) httpError(404, 'Invalid Request - [Name] not found');

	$data = $updatedata[$name];

	print($data['Name']."<hr>".$data['Version']."<hr>".$data['Link']);