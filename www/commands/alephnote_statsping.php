<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


if (!isset($API_OPTIONS['name']))        { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['clientid']))    { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['version']))     { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['providerstr'])) { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['providerid']))  { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }
if (!isset($API_OPTIONS['notecount']))   { $FRAME_OPTIONS->forceResult(400, "Wrong parameters."); return; }

$nam = $API_OPTIONS['name'];
$cid = $API_OPTIONS['clientid'];

$values = [];

$values['Version']     = $API_OPTIONS['version'];
$values['ProviderStr'] = $API_OPTIONS['providerstr'];
$values['ProviderID']  = $API_OPTIONS['providerid'];
$values['NoteCount']   = $API_OPTIONS['notecount'];

$values['RawFolderRepo']                = isset($_GET['RawFolderRepo'])                ? $_GET['RawFolderRepo']                : null;
$values['RawFolderRepoMode']            = isset($_GET['RawFolderRepoMode'])            ? $_GET['RawFolderRepoMode']            : null;
$values['GitMirror']                    = isset($_GET['GitMirror'])                    ? $_GET['GitMirror']                    : null;
$values['GitMirrorPush']                = isset($_GET['GitMirrorPush'])                ? $_GET['GitMirrorPush']                : null;
$values['Theme']                        = isset($_GET['Theme'])                        ? $_GET['Theme']                        : null;
$values['LaunchOnBoot']                 = isset($_GET['LaunchOnBoot'])                 ? $_GET['LaunchOnBoot']                 : null;
$values['EmulateHierarchicalStructure'] = isset($_GET['EmulateHierarchicalStructure']) ? $_GET['EmulateHierarchicalStructure'] : null;
$values['HasEditedAdvancedSettings']    = isset($_GET['HasEditedAdvancedSettings'])    ? $_GET['HasEditedAdvancedSettings']    : null;
$values['AdvancedSettingsDiff']         = isset($_GET['AdvancedSettingsDiff'])         ? $_GET['AdvancedSettingsDiff']         : null;

if ($nam !== 'AlephNote') print('{"success":false, "message":"Unknown AppName"}');

/** @noinspection SqlInsertValues */
$sql = 'INSERT INTO an_statslog (ClientID, '.join(', ', array_keys($values)).') VALUES (:cid, '.join(', ', array_map(function($v) {return ':'.$v.'_1';}, array_keys($values))).') ON DUPLICATE KEY UPDATE '.join(', ', array_map(function($v) {return $v.'=:'.$v.'_2';}, array_keys($values)));

$params = [];
$params []= [':cid', $cid, PDO::PARAM_STR];
foreach ($values as $k => $v) $params []= [':'.$k.'_1', $v, ($k=='NoteCount') ? PDO::PARAM_INT : PDO::PARAM_STR];
foreach ($values as $k => $v) $params []= [':'.$k.'_2', $v, ($k=='NoteCount') ? PDO::PARAM_INT : PDO::PARAM_STR];

$SITE->modules->Database()->sql_exec_prep($sql, $params);

print('{"success":true}');

