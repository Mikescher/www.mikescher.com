<?php

return [
		'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name' => 'Mikescher.com - Console',

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
				'yii.debug' => defined('YII_DEBUG'),
				'yii.traceLevel' => 3,
				'yii.handleErrors' => defined('YII_DEBUG'),
				// this is used in contact page
				'adminEmail' => 'kundenservice@mikescher.de',
			],
	];