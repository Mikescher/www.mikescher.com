<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egh/ExtendedGitGraph2.php');
require_once (__DIR__ . '/../internals/mikeschergitgraph.php');

set_time_limit(900); // 15min

$v = MikescherGitGraph::create();
$v->update();

