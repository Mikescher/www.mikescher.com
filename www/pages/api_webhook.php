<?php

global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');

$hook   = $OPTIONS['target'];
$secret = $OPTIONS['secret'];
$uri    = $OPTIONS['uri'];

if ($secret !== $CONFIG['webhook_secret']) die('Unauthorized.');

$cmd = "";

if ($hook == 'website_mikescher') $cmd = 'git pull';
else if ($hook == 'griddominance') $cmd = 'update-gdapi';
else throw new Exception("Unknown webhook: $hook");


$std = shell_exec($cmd);

$content = "REQUEST: " . $uri . "\r\n\r\n" .
		   "IP:      " . get_client_ip() . "\r\n\r\n" .
	       "TARGET:  " . $hook . "\r\n\r\n" .
	       "OUTPUT:  " . $std . "\r\n\r\n";

sendMail("Webhook '$hook' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-error@mikescher.com');