<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */
?>

<?php
$this->breadcrumbs=array(
	'Euler Problems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EulerProblem', 'url'=>array('index')),
	array('label'=>'Manage EulerProblem', 'url'=>array('admin')),
);
?>

<h1>Create EulerProblem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>