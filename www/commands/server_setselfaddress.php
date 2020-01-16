<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$ip = get_client_ip();

file_put_contents(__DIR__ . '/../dynamic/self_ip_address.auto.cfg', $ip);

system('add-trusted-ip "' . $ip . '"');

echo 'Ok.';
