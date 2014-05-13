<?php

return array(
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=rdbms.strato.de;dbname=DB451718',
			'username' => 'U451718',
			'password' => 'Datenbank',
			'enableProfiling' => false,
			'enableParamLogging' => false,
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

	),

	'params' => array(
		'yii.debug' => false,
		'yii.traceLevel' => 3,
		'yii.handleErrors'   => false,
	)
);