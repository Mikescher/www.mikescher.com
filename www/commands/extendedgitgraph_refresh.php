<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

set_time_limit(6*60*60); // 6h

$r1 = $SITE->modules->ExtendedGitGraph()->update();
if (!$r1)
{
	http_response_code(500);
	echo 'EGG::update failed.';
}

$r2 = $SITE->modules->ExtendedGitGraph()->updateCache();
if (!$r2)
{
	http_response_code(500);
	echo 'EGG::updateCache failed.';
}

http_response_code(200);
echo 'Done.';