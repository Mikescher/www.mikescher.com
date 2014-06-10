<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// dev or prod - merges settings with respective file
defined('YII_CUSTOM_ENV') or define('YII_CUSTOM_ENV', 'dev');

require_once($yii);
Yii::createWebApplication($config)->run();


// TODO-MS Add title property to pages
// TODO-MS Add Metadata property to pages (especially programs) ->Search engines
// TODO-MS More contrast in design ???
// TODO-MS Add Favicon
// TODO-MS Add Blog
// TODO-MS Add Search (Blog + progs + log) jew auch metadata / desc ...
// TODO-MS Add Prog Display
