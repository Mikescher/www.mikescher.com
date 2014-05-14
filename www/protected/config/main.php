<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once('protected/lib/ArrayX.php');
use Yiinitializr\Helpers\ArrayX;

return ArrayX::merge(
	[
		'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name' => 'Mikescher.de',

		// preloading 'log' component
		'preload' =>
			[
				'log'
			],

		'aliases' =>
			[
				'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
			],

		// autoloading model and component classes
		'import' =>
			[
				'application.models.*',
				'application.components.*',
				'bootstrap.components.*',
				'bootstrap.behaviors.*',
				'bootstrap.helpers.*',
			],

		'modules' =>
			[
				//
			],

		// application components
		'components' =>
			[
				'bootstrap' =>
					[
						'class' => 'bootstrap.components.TbApi',
					],

				'user' =>
					[
						// enable cookie-based authentication
						'allowAutoLogin' => true,
					],

				// uncomment the following to enable URLs in path-format

				'urlManager' =>
					[
						'urlFormat' => 'path',
						'caseSensitive' => false,
						'showScriptName' => true,
						'rules' =>
							[

								'' => 'site/index',
								'<action:\w+>' => 'site/<action>',

								'gii' => 'gii',
								'gii/<controller:\w+>' => 'gii/<controller>',
								'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',

								//'<controller:\w+>/<id:\d+>'                 =>  '<controller>/view',
								//'<controller:\w+>/<action:\w+>/<id:\d+>'    =>  '<controller>/<action>',
								'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
							],
					],


				'log' =>
					[
						'class' => 'CLogRouter',
						'routes' =>
							[
								[
									'class' => 'CFileLogRoute',
									'levels' => 'error, warning',
								],
							],
					],
			],

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' =>
			[
				// this is used in contact page
				'adminEmail' => 'webmaster@example.com',
			],
	], require_once('env/' . YII_CUSTOM_ENV . '.php'));