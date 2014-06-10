<?php
/* @var $this LogController */
/* @var $model Log */
?>

<?php

$this->pageTitle = 'View Log - ' . Yii::app()->name;


$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Log', 'url'=>array('index')),
	array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'Update Log', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Log', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

<h1>View Log #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'ID',
		'date',
		'title',
		'content',
	),
)); ?>