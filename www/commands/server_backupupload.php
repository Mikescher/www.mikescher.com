<?php

global $API_OPTIONS;
global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');

if (!isset($API_OPTIONS['folder']))   httpDie(400, "Wrong parameters.");
if (!isset($API_OPTIONS['filename'])) httpDie(400, "Wrong parameters.");

$folder   = $API_OPTIONS['folder'];
$filename = $API_OPTIONS['filename'];
$uri      = $OPTIONS['uri'];

$reltarget = "Backup/$folder/$filename";

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
