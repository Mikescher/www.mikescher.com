<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');

	$name = $OPTIONS['name'];

	Database::connect();

	$data = Database::sql_query_single_prep('SELECT * FROM ms4_updates WHERE Name = :n',
	[
		[':n', $name, PDO::PARAM_STR],
	]);

	if ($data == NULL) httpError(404, 'Invalid Request - [Name] not found');

	print($data['Name']."<hr>".$data['Version']."<hr>".$data['Link']);