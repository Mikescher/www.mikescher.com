<?php
/* @var $this ProgramUpdatesController */
/* @var $model ProgramUpdates */
?>

<?php
$this->breadcrumbs=array(
	'Program Updates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProgramUpdates', 'url'=>array('index')),
	array('label'=>'Manage ProgramUpdates', 'url'=>array('admin')),
);
?>

<h1>Create ProgramUpdates</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>