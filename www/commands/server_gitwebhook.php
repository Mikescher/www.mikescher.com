<?php

global $API_OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');

if (!isset($API_OPTIONS['target'])) die("Wrong parameters.");
if (!isset($API_OPTIONS['secret'])) die("Wrong parameters.");
if (!isset($API_OPTIONS['uri']))    die("Wrong parameters.");

$hook   = $API_OPTIONS['target'];
$secret = $API_OPTIONS['secret'];
$uri    = $API_OPTIONS['uri'];

$cmd = "";

if ($hook == 'website_mikescher')  $cmd = 'git pull';
else if ($hook == 'griddominance') $cmd = 'update-gdapi';
else                               die("Unknown webhook: $hook");

$std = shell_exec($cmd);

$content = "REQUEST: " . $uri . "\r\n\r\n" .
		   "IP:      " . get_client_ip() . "\r\n\r\n" .
	       "TARGET:  " . $hook . "\r\n\r\n" .
	       "OUTPUT:  " . $std . "\r\n\r\n";

sendMail("Webhook '$hook' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');
