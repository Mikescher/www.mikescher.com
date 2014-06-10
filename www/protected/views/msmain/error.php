<?php
/* @var $this MsMainController */
/* @var $error array */

	$this->pageTitle='Error - ' . Yii::app()->name;
	
	$this->breadcrumbs=array(
		'Error',
	);

	$this->widget('bootstrap.widgets.TbHeroUnit', array(
		'heading' => 'ERROR ' . $code,
		'content' => $message,
	));
?>
