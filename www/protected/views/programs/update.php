<?php
/* @var $this ProgramController */
/* @var $model Program */
?>

<?php
$this->breadcrumbs=array(
	'Programs'=>array('index'),
	$model->Name=>array('view','id'=>$model->ID),
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