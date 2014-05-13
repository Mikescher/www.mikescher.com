<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once('protected/lib/ArrayX.php');
use Yiinitializr\Helpers\ArrayX;

return ArrayX::merge(array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mikescher.de',

	// preloading 'log' component
	'preload'=>array('log'),

	'aliases' => array(
		'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.components.*',
		'bootstrap.behaviors.*',
		'bootstrap.helpers.*',

	),

	'modules'=>array(
		//
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',   
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
	), require_once('env/' . YII_CUSTOM_ENV . '.php'));