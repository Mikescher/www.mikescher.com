<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/programs.php');
require_once (__DIR__ . '/../internals/ParsedownCustom.php');

$internalname = $OPTIONS['id'];

$prog = Programs::getProgramByInternalName($internalname);
if ($prog === NULL) httpError(404, 'Program not found');

// This page is only for old links.
// Current version does use direct links

foreach (Programs::getURLs($prog) as $xurl)
{
	if ($xurl['type'] === 'download')       { header('Location: ' . $xurl['href']); exit; }
	if ($xurl['type'] === 'playstore')      { header('Location: ' . $xurl['href']); exit; }
	if ($xurl['type'] === 'amazonappstore') { header('Location: ' . $xurl['href']); exit; }
	if ($xurl['type'] === 'windowsstore')   { header('Location: ' . $xurl['href']); exit; }
	if ($xurl['type'] === 'itunesstore')    { header('Location: ' . $xurl['href']); exit; }
}