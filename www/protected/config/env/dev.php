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

		],


	'params' =>
		[
			'yii.debug' => true,
			'yii.traceLevel' => 3,
			'yii.handleErrors' => true,
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