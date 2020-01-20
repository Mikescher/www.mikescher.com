<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['filter'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }


$json = $SITE->modules->SelfTest()->run($API_OPTIONS['filter']);

echo json_encode($json);