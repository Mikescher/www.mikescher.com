<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['folder']))   { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['filename'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$folder   = $API_OPTIONS['folder'];
$filename = $API_OPTIONS['filename'];
$uri      = $ROUTE->full_url;

$reltarget = "Backup/$folder/$filename";

$putdata = fopen("php://input", "r");
$fp = tmpfile();
$tmppath = stream_get_meta_data($fp)['uri'];
while ($data = fread($putdata, 1024)) fwrite($fp, $data);
fclose($putdata);

$std = shell_exec("ncc_upload " . '"' . $tmppath . '" "' . $reltarget . '" 2>&1');

fclose($fp);

$content = "REQUEST: " . $uri            . "\n\n" .
		   "IP:      " . get_client_ip() . "\n\n" .
	       "TARGET:  " . $reltarget      . "\n\n" .
	       "OUTPUT:  " . $std            . "\n\n";

sendMail("Fileupload to '$folder' triggered", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

echo "OK.\n\n";
echo $content;
