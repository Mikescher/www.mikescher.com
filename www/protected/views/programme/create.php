<?php
/* @var $this ProgrammeController */
/* @var $model Programme */
?>

<?php
$this->breadcrumbs=array(
	'Programmes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Programme', 'url'=>array('index')),
	array('label'=>'Manage Programme', 'url'=>array('admin')),
);
?>

<h1>Create Programme</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>