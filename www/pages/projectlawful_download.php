<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$variant = $ROUTE->parameter['variant'];

if (!$SITE->modules->ProjectLawful()->variantExists($variant))
{
    $FRAME_OPTIONS->setForced404('epub file not found');
    return;
}

$SITE->modules->ProjectLawful()->insertDownload($variant);

$FRAME_OPTIONS->setForcedRedirect('/data/projectlawful/project-lawful-' . $variant . '.epub');
