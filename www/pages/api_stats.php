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
		
		Database::sql_exec_prep('INSERT INTO an_statslog (ClientID, Version, ProviderStr, ProviderID, NoteCount) VALUES (:cid, :ver, :prv, :pid, :tnc) ON DUPLICATE KEY UPDATE Version=:ver,ProviderStr=:prv,ProviderID=:pid,NoteCount=:tnc',
		[
			[':cid', $cid, PDO::PARAM_STR],
			[':ver', $ver, PDO::PARAM_STR],
			[':prv', $prv, PDO::PARAM_STR],
			[':pid', $pid, PDO::PARAM_STR],
			[':tnc', $tnc, PDO::PARAM_INT],
		]);
		
		print('{"success":true}');
	}
	else 
	{
		print('{"success":false, "message":"Unknown AppName"}');
	}
