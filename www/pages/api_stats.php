<?php
	global $OPTIONS;

	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');

	$nam = $OPTIONS['name'];
	$cid = $OPTIONS['clientid'];
	$ver = $OPTIONS['version'];
	$prv = $OPTIONS['providerstr'];
	$pid = $OPTIONS['providerid'];
    $tnc = $OPTIONS['notecount'];

	if ($nam === 'AlephNote')
	{
		Database::connect();
		
		Database::sql_exec_prep('INSERT INTO an_statslog (ClientID, Version, ProviderStr, ProviderID, NoteCount) VALUES (:cid1, :ver1, :prv1, :pid1, :tnc1) ON DUPLICATE KEY UPDATE Version=:ver2,ProviderStr=:prv2,ProviderID=:pid2,NoteCount=:tnc2',
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
	}
	else 
	{
		print('{"success":false, "message":"Unknown AppName"}');
	}
