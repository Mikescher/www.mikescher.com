#!/usr/bin/php

<?php

if (php_sapi_name() !== "cli") die("[cli only!]");

set_time_limit(6*60*60); // 6h
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
ini_set('memory_limit', '1024M');
error_reporting(E_ALL);

try {

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
    echo "============================= Check Consistency =============================\n";
    echo "\n";

    $r2 = $egg->checkDatabaseConsistency();
    if (count($r2) > 0)
    {
        echo "EGG::updateCache failed.\n";
        foreach ($r2 as $msg) {
            echo "    > $msg\n";
        }
        exit(99);
    }

    echo "\n";
    echo "============================= Update Cache =============================\n";
    echo "\n";

    $r3 = $egg->updateCache();
    if (!$r3)
    {
        echo "EGG::updateCache failed.";
        exit(99);
    }

    echo "\n";
    echo "==============================================================================\n";
    echo "\n";

    echo "Done.\n";
    exit(0);

} catch (Throwable $throwable) {

    echo "";
    echo "[!] Caught Eception";
    echo "";

    echo $throwable->getMessage();
    echo $throwable->getFile() . " : " . $throwable->getLine();
    echo "";
    echo $throwable->getTraceAsString();

    echo "";
    echo "";

    throw $throwable;
}