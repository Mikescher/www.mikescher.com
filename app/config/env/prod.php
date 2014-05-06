<?php
/**
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
return array(
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=rdbms.strato.de;dbname=DB451718',
			'username' => 'U451718',
			'password' => 'Datenbank',
			'enableProfiling' => YII_DEBUG,
			'enableParamLogging' => YII_DEBUG,
			'charset' => 'utf8',
		),
	),
	'params' => array(
		'yii.debug' => false,
		'yii.traceLevel' => 0,
		'yii.handleErrors'   => APP_CONFIG_NAME !== 'test',
	)
);