<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egh/ExtendedGitGraph.php');

$cmd = $OPTIONS['cmd'];
$secret = $OPTIONS['secret'];

if (isset($OPTIONS['suffix'])) $cmd = $OPTIONS['suffix'] . '::' . $cmd;
$cmd = strtolower($cmd);

if ($secret !== $CONFIG['ajax_secret']) die('Unauthorized.');

if ($cmd === 'egh::status')  { include (__DIR__ . '/../ajax/egh_status.php');  exit; }
if ($cmd === 'egh::refresh') { include (__DIR__ . '/../ajax/egh_refresh.php'); exit; }
if ($cmd === 'egh::redraw')  { include (__DIR__ . '/../ajax/egh_redraw.php');  exit; }

if ($cmd === 'alephnotetable')  { include (__DIR__ . '/../ajax/an_activeusers.php');  exit; }

die('Wrong command.');