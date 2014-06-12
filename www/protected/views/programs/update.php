<?php
/* @var $this ProgramsController */
/* @var $model Program */
?>

<?php

$this->pageTitle = 'Update Program - ' . Yii::app()->name;

$this->breadcrumbs=array(
	'Programs' => array('index'),
	$model->Name => array($model->getLink()),
	'Update',
);

$this->menu=array(
	array('label'=>'List Program', 'url'=>array('index')),
	array('label'=>'Create Program', 'url'=>array('create')),
	array('label'=>'View Program', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage Program', 'url'=>array('admin')),
);
?>

    <h1>Update Program <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>