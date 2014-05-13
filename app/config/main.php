<?php
/**
 *
 * main.php configuration file
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
defined('APP_CONFIG_NAME') or define('APP_CONFIG_NAME', 'main');

use Yiinitializr\Helpers\ArrayX;

// web application configuration
return ArrayX::merge(array(
	'name' => 'Mikescher_de',

	// path aliases
	'aliases' => array(
		'bootstrap' => dirname(__FILE__) . '/../lib/vendor/2amigos/yiistrap',
		'yiiwheels' => dirname(__FILE__) . '/../lib/vendor/2amigos/yiiwheels',
	),
 
	// application behaviors
	'behaviors' => array(),

	// controllers mappings
	'controllerMap' => array(),

	// application modules
	'modules' => array(),

	// application components
	'components' => array(

		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',
		),

		'clientScript' => array(
			'scriptMap' => array(
				'bootstrap.min.css' => false,
				'bootstrap.min.js' => false,
				'bootstrap-yii.css' => false
			)
		),
		
		'user' => array(
			'allowAutoLogin' => true,
		),
		
		'errorHandler' => array(
			'errorAction' => 'site/error',
		)
	),
	// application parameters
	'params' => array(),
), require_once('common.php'));