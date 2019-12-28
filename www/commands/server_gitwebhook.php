<?php

global $API_OPTIONS;
global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');

if (!isset($API_OPTIONS['target'])) httpDie(400, "Wrong parameters.");

$hook   = $API_OPTIONS['target'];
$uri    = $OPTIONS['uri'];

$cmd = "";

if ($hook == 'website_mikescher')  $cmd = 'git pull';
else if ($hook == 'griddominance') $cmd = 'update-gdapi';
else                               httpDie(400, "Unknown webhook: $hook");

$std = shell_exec($cmd);

$content = "REQUEST: " . $uri . "\r\n\r\n" .
		   "IP:      " . get_client_ip() . "\r\n\r\n" .
	       "TARGET:  " . $hook . "\r\n\r\n" .
	       "OUTPUT:  " . $std . "\r\n\r\n";

sendMail("Webhook '$hook' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

echo "{ 'status': 'ok', 'message': 'Webhook '$hook' triggered' }";