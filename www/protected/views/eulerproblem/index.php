<?php
/* @var $this EulerProblemController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Euler Problems',
);

$this->menu=array(
	array('label'=>'Create EulerProblem','url'=>array('create')),
	array('label'=>'Manage EulerProblem','url'=>array('admin')),
);
?>

<h1>Euler Problems</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type'=>'striped bordered condensed',

	'dataProvider'=>$dataProvider,

	'columns'=>array(
		'Problemnumber',
		'Problemtitle',
		'Problemdescription',
		'AbbreviatedCode',
		'SolutionWidth',
		'SolutionHeight',
		'SolutionSteps',
		'SolutionTime',
		'SolutionValue',
	),
)); ?>