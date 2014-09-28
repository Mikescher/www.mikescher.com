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
				'application.extensions.*',
				'application.components.*',
				'application.components.widgets.*',
				'application.components.extendedgitgraph.*',
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
				'hitcounter' =>
					[
						'class' => 'CHitCounter',

						'table_stats' => '{{hc_stats}}',
						'table_today' => '{{hc_today}}',
					],

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
								'programs/download/<id>' => 'programs/download',

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
								'blog/<id>/<name>' => 'blogPost/view/id/<id>',

								'eulerProblem/' => 'eulerProblem/index',

								'Highscores/list.php' => 'Highscores/list',				// Compatibility
								'Highscores/insert.php' => 'Highscores/insert',			// Compatibility
								'Highscores/update.php' => 'Highscores/update',			// Compatibility
								'Highscores/list_top50.php' => 'Highscores/list_top50',	// Compatibility
								'Highscores/getNewID.php' => 'Highscores/newID',		// Compatibility

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

				'counter' => array(
					'class' => 'UserCounter',
				),
			],

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' =>
			[
				'yii.debug' => defined('YII_DEBUG'),
				'yii.traceLevel' => 3,
				'yii.handleErrors' => defined('YII_DEBUG'),
				// this is used in contact page
				'adminEmail' => 'kundenservice@mikescher.de',
			],
	]);