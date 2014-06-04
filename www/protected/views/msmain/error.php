<?php
/* @var $this SiteController */
/* @var $error array */

	$this->pageTitle=Yii::app()->name . ' - Error';
	
	$this->breadcrumbs=array(
		'Error',
	);

	$this->widget('bootstrap.widgets.TbHeroUnit', array(
		'heading' => 'ERROR ' . $code,
		'content' => $message,
	));
?>
