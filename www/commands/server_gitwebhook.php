<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['target']))   { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$hook   = $API_OPTIONS['target'];
$uri    = $ROUTE->full_url;

$cmd = "";

if ($hook == 'website_mikescher')
	$cmd = 'git fetch ; git reset origin/master --hard';
else if ($hook == 'griddominance')
	$cmd = 'update-gdapi';
else
{
	$FRAME_OPTIONS->forceResult(400, "Unknown webhook: $hook");
	return;
}

$std = shell_exec($cmd);

$content = "REQUEST: " . $uri            . "\n\n" .
		   "IP:      " . get_client_ip() . "\n\n" .
	       "TARGET:  " . $hook           . "\n\n" .
	       "OUTPUT:  " . $std            . "\n\n";

sendMail("Webhook '$hook' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

echo "{ 'status': 'ok', 'message': 'Webhook '$hook' triggered' }";