<?php

return array(
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db451718',
			'username' => 'root',
			'password' => '',
			'enableProfiling' => true,
			'enableParamLogging' => true,
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

	),
	

	'params' => array(
		'yii.debug' => true,
		'yii.traceLevel' => 3,
		'yii.handleErrors'   => true,
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'giipw',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	
	),

);