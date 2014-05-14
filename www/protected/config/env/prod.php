<?php

return [
	'components' =>
		[
			'db' =>
				[
					'connectionString' => 'mysql:host=rdbms.strato.de;dbname=DB451718',
					'username' => 'U451718',
					'password' => 'Datenbank',
					'enableProfiling' => false,
					'enableParamLogging' => false,
					'charset' => 'utf8',
					'emulatePrepare' => true, // needed by some MySQL installations
					'schemaCachingDuration' => 3600, // Performance with AR's
				],

			'errorHandler' =>
				[
					'errorAction' => 'site/error',
				],

		],

	'params' =>
		[
			'yii.debug' => false,
			'yii.traceLevel' => 3,
			'yii.handleErrors' => false,
		],
];