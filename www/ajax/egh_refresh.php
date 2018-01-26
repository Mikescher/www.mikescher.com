<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egh/ExtendedGitGraph.php');
require_once (__DIR__ . '/../internals/mikeschergitgraph.php');

set_time_limit(900); // 15min

$v = MikescherGitGraph::create();
$v->init();
$v->updateFromRemotes();
$v->generate();

file_put_contents(__DIR__ . '/../dynamic/egh.html', $v->getAll());

