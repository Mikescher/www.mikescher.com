<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */
?>

<?php
$this->breadcrumbs=array(
	'Euler Problems'=>array('index'),
	'#' . $model->Problemnumber=>array('view','id'=>$model->Problemnumber),
	'Update',
);

$this->menu=array(
	array('label'=>'List EulerProblem', 'url'=>array('index')),
	array('label'=>'Create EulerProblem', 'url'=>array('create')),
	array('label'=>'View EulerProblem', 'url'=>array('view', 'id'=>$model->Problemnumber)),
	array('label'=>'Manage EulerProblem', 'url'=>array('admin')),
);
?>

    <h1>Update EulerProblem <?php echo $model->Problemnumber; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>