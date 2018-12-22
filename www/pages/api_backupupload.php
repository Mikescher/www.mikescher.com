<?php

global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');

$folder   = $OPTIONS['folder'];
$filename = $OPTIONS['filename'];
$secret   = $OPTIONS['secret'];
$uri      = $OPTIONS['uri'];

$reltarget = "Backup/$folder/$filename";

if ($secret !== $CONFIG['upload_secret']) die('Unauthorized.');

$putdata = fopen("php://input", "r");
$fp = tmpfile();
$tmppath = stream_get_meta_data($fp)['uri'];
while ($data = fread($putdata, 1024)) fwrite($fp, $data);
fclose($fp);
fclose($putdata);

$std = shell_exec("sudo ncc_upload " . '"' . $tmppath . '" "' . $reltarget . '"'); // ncc_upload is allowed for all in /etc/sudoers

$content = "REQUEST: " . $uri            . "\r\n\r\n" .
		   "IP:      " . get_client_ip() . "\r\n\r\n" .
	       "TARGET:  " . $reltarget      . "\r\n\r\n" .
	       "OUTPUT:  " . $std            . "\r\n\r\n";

sendMail("Fileupload to '$folder' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-error@mikescher.com');