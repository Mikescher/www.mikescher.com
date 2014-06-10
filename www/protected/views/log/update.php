<?php
/* @var $this LogController */
/* @var $model Log */
?>

<?php

$this->pageTitle = 'Update Log - ' . Yii::app()->name;


$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->title=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Log', 'url'=>array('index')),
	array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'View Log', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

    <h1>Update Log <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>