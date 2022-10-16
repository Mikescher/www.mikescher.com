#!/usr/bin/php

<?php

if (php_sapi_name() !== "cli") die("[cli only!]");

set_time_limit(6*60*60); // 6h
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

echo "\n";
echo "==================================== Init ====================================\n";
echo "\n";

$config = (require (__DIR__ . '/../config.php'))['extendedgitgraph'];
$config['output_session'] = false;
$config['output_file'] = false;
$config['output_stdout'] = true;

require_once __DIR__ .'/../internals/modules/mikeschergitgraph.php';

$egg = new MikescherGitGraph($config);

echo "\n";
echo "================================ Start Update ================================\n";
echo "\n";

$r1 = $egg->update();
if (!$r1)
{
	echo "EGG::update failed.\n";
	exit(99);
}

echo "\n";
echo "============================= Start Update-Cache =============================\n";
echo "\n";

$r2 = $egg->updateCache();
if (!$r2)
{
	echo "EGG::updateCache failed.";
	exit(99);
}

echo "\n";
echo "==============================================================================\n";
echo "\n";

echo "Done.\n";
exit(0);