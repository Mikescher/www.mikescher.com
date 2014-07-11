<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once('protected/lib/ArrayX.php');
use Yiinitializr\Helpers\ArrayX;

return ArrayX::merge(
	require_once('env/' . YII_CUSTOM_ENV . '.php'),
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
				'application.components.widgets.*',
				'application.components.extendedGitGraph.*',
				'application.components.parsedown.*',
				'bootstrap.components.*',
				'bootstrap.behaviors.*',
				'bootstrap.helpers.*',
				'bootstrap.widgets.*',
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
						'loginUrl'=> ['msmain/login'],
					],

				'urlManager' =>
					[
						'urlFormat' => 'path',
						'caseSensitive' => false,
						'showScriptName' => false,
						'rules' =>
							[
								'programs/' => ['programs/index', 'defaultParams' => ['categoryfilter' => '']],
								'programs/cat/<categoryfilter>' => ['programs/index', 'defaultParams' => ['categoryfilter' => '']],
								'programs/view/<id>' => 'programs/view',

								'log/' => ['log/index', 'defaultParams' => ['logid' => '-1']],
								'log/<logid:[0-9]+>' => ['log/index', 'defaultParams' => ['logid' => '-1']],

								'programupdates/' => 'programupdates/index',

								'update.php' => 'api/update',
								'update.php/<Name>' => 'api/update2',
								'update' => 'api/update',
								'update/<Name>' => 'api/update2',

								'blog/' => 'blogPost/index',
								'blog/ajaxMarkdownPreview' => 'blogPost/ajaxMarkdownPreview',
								'blog/admin' => 'blogPost/admin',
								'blog/create' => 'blogPost/create',
								'blog/index' => 'blogPost/index',
								'blog/update' => 'blogPost/update',
								'blog/<id>' => 'blogPost/view/id/<id>',

								'downloads/details.php' => 'programs/index', 	// Compatibility
								'downloads/downloads.php' => 'programs/index', 	// Compatibility
								'downloads/<id>' => 'programs/view', 			// Compatibility

								'' => 'msmain/index',

								'<action:\w+>' => 'msmain/<action>',
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

				'db' =>
					[
						'tablePrefix' => 'ms4_',
					],
			],

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' =>
			[
				// this is used in contact page
				'adminEmail' => 'webmaster@example.com',
			],
	]);