<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */
?>

<?php
$this->breadcrumbs=array(
	'Euler Problems'=>array('index'),
	'#' . $model->Problemnumber,
);

$this->menu=array(
	array('label'=>'List EulerProblem', 'url'=>array('index')),
	array('label'=>'Create EulerProblem', 'url'=>array('create')),
	array('label'=>'Update EulerProblem', 'url'=>array('update', 'id'=>$model->Problemnumber)),
	array('label'=>'Delete EulerProblem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Problemnumber),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EulerProblem', 'url'=>array('admin')),
);
?>

<h1>View EulerProblem #<?php echo $model->Problemnumber; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'Problemnumber',
		'Problemdescription',
		'Code',
		'Explanation',
		'AbbreviatedCode',
		'SolutionSteps',
		'SolutionTime',
		'SolutionValue',
	),
)); ?>