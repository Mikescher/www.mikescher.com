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
fclose($putdata);

$std = shell_exec("ncc_upload " . '"' . $tmppath . '" "' . $reltarget . '" 2>&1');

fclose($fp);

$content = "REQUEST: " . $uri            . "\r\n\r\n" .
		   "IP:      " . get_client_ip() . "\r\n\r\n" .
	       "TARGET:  " . $reltarget      . "\r\n\r\n" .
	       "OUTPUT:  " . $std            . "\r\n\r\n";

sendMail("Fileupload to '$folder' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

echo "OK.\n\n";
echo $content;
