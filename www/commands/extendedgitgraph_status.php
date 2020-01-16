<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if ($SITE->config['extendedgitgraph']['output_file'])
{
	$lfile = $SITE->config['extendedgitgraph']['output_filepath'];

	if (file_exists($lfile))
	{
		$data = file_get_contents($lfile);

		if ($data === '') echo '[[ EMPTY ]]';
		else echo $data;
	}
	else
	{
		echo '[[ FILE NOT FOUND ]]';
	}
}
else if ($SITE->config['extendedgitgraph']['output_file'])
{
	if (session_status() !== PHP_SESSION_ACTIVE) session_start();

	$svar = $SITE->config['extendedgitgraph']['session_var'];

	if (isset($_GET['clear'])) if (key_exists($svar, $_SESSION)) $_SESSION[$svar] = '';

	if (key_exists($svar, $_SESSION))
	{
		if ($_SESSION[$svar] === '') echo '[[ NO OUTPUT ]]';
		else echo $_SESSION[$svar];
	}
	else
	{
		echo '[[ NO SESSION STARTED ]]';
	}
}
else
{
	echo '[[ NO USEFUL LOGGER CONFIGURED ]]';
}
