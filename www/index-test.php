<?php
echo "Mikescher.de - " . date('Y-m-d H:i:s') . "<br>\n";
echo "\n<hr>\n";
echo "File: " . __FILE__ . "<br>\n";
echo "[C] Time: " . date("F d Y H:i:s.", filectime(__FILE__)) . "<br>\n";
echo "[M] Time: " . date("F d Y H:i:s.", filemtime(__FILE__)) . "<br>\n";
echo "[MD5] File: " . md5_file (__FILE__) . "<br>\n";
echo "\n<hr>\n";
echo "POST:" . print_r($_POST, true);
echo "\n<hr>\n";
echo "GET:" . print_r($_GET, true);
echo "\n<hr>\n";
echo dirname(__FILE__);
echo "\n<hr>\n";
echo dirname(__FILE__) . '/../framework/yii.php';
echo "\n<hr>\n";
echo dirname(__FILE__) . '/protected/config/main.php';
echo "\n<hr>\n";
print_r( scandir("/") );
echo "\n<hr>\n";
print_r( scandir(".") );
echo "\n<hr>\n";
print_r( scandir(dirname(__FILE__)) );
echo "\n<hr>\n";
print_r( scandir(dirname(__FILE__) . '/protected/') );
echo "\n<hr>\n";
print_r( scandir(dirname(__FILE__) . '/protected/controllers/') );
echo "\n<hr>\n";
print_r( scandir('/mnt/web1/e3/60/51559660/htdocs/www/protected/controllers/') );
echo "\n<hr>\n";
print_r( scandir('/') );
echo "\n<hr>\n";
print_r( scandir('/../') );
echo "\n<hr>\n";
print_r( scandir('/../framework/') );
echo "\n<hr>\n";
/*?*/ echo ( is_file('/mnt/web1/e3/60/51559660/htdocs/www/protected/controllers/MsmainController.php') ? 'true' : 'false' ) . "<br>\n";
/*-*/ echo ( is_file('/mnt/web1/e3/60/51559660/htdocs/www/protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
/*-*/ echo ( is_file('/protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
/*+*/ echo ( is_file('protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
/*-*/ echo ( is_file('/www/protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
/*+*/ echo ( is_file('protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
/*+*/ echo ( is_file(dirname(__FILE__) . '/protected/controllers/MSMainController.php') ? 'true' : 'false' ) . "<br>\n";
echo "\n<hr>\n";
print_r( scandir(dirname(__FILE__) . '/protected/views/') );
echo "\n<hr>\n";

// change the following paths if necessary
$yii= dirname(__FILE__) . '/../framework/yii.php';
$config= dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// dev or prod - merges settings with respective file
defined('YII_CUSTOM_ENV') or define('YII_CUSTOM_ENV', 'prod');

require_once($yii);
Yii::createWebApplication($config)->run();


// TODO-MS Add Blog
// TODO-MS Add Search (Blog + progs + log) jew auch metadata / desc ...
// TODO-MS Add Prog Display
