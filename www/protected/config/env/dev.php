<?php

return [
	'components' =>
		[
			'db' =>
				[
					'connectionString' => 'mysql:host=localhost;dbname=db451718',
					'username' => 'root',
					'password' => '',
					'enableProfiling' => true,
					'enableParamLogging' => true,
					'charset' => 'utf8',
					//'emulatePrepare'=>true,  // needed by some MySQL installations
					'schemaCachingDuration' => 3600, // Performance with AR's
				],

			'errorHandler' =>
				[
					'errorAction' => 'msmain/debugerror',
				],

			'urlManager' =>
				[
					'rules' =>
						[
							'gii'=>'gii',
							'gii/<controller:\w+>'=>'gii/<controller>',
							'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
						],
				],
		],

	'modules' =>
		[
			'gii' =>
				[
					'class' => 'system.gii.GiiModule',
					'generatorPaths' => ['bootstrap.gii'],
					'password' => 'giipw',
					'ipFilters' => ['127.0.0.1', '::1'],
				],

		],

];