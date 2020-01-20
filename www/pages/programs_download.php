<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$progid = $ROUTE->parameter['id'];

$prog = $SITE->modules->Programs()->getProgramByInternalName($progid);
if ($prog === null) { $FRAME_OPTIONS->setForced404("Program not found"); return; }

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;

$FRAME_OPTIONS->frame = 'nocontent_frame.php';

foreach ($SITE->modules->Programs()->getURLs($prog) as $xurl)
{
	if ($xurl['type'] === 'download')       { $FRAME_OPTIONS->setForcedRedirect($xurl['href']); return; }
	if ($xurl['type'] === 'playstore')      { $FRAME_OPTIONS->setForcedRedirect($xurl['href']); return; }
	if ($xurl['type'] === 'amazonappstore') { $FRAME_OPTIONS->setForcedRedirect($xurl['href']); return; }
	if ($xurl['type'] === 'windowsstore')   { $FRAME_OPTIONS->setForcedRedirect($xurl['href']); return; }
	if ($xurl['type'] === 'itunesstore')    { $FRAME_OPTIONS->setForcedRedirect($xurl['href']); return; }
}
?>
