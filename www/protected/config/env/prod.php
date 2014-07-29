<?php

require_once('protected/lib/ArrayX.php');
use Yiinitializr\Helpers\ArrayX;

return [
	'components' =>
		[
			'db' =>
				ArrayX::merge(
					[
						'connectionString' => 'mysql:host=rdbms.strato.de;dbname=DB451718',
						'enableProfiling' => false,
						'enableParamLogging' => false,
						'charset' => 'utf8',
						'emulatePrepare' => true, // needed by some MySQL installations
						'schemaCachingDuration' => 3600, // Performance with AR's
					],
					require_once('database-access.secret.php') // DB Username & PW
				),

			'errorHandler' =>
				[
					'errorAction' => 'msmain/error',
				],

		],

	'params' =>
		[
			'yii.debug' => false,
			'yii.traceLevel' => 3,
			'yii.handleErrors' => false,
		],
];