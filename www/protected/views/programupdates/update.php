<?php
/* @var $this ProgramUpdatesController */
/* @var $model ProgramUpdates */
?>

<?php
$this->breadcrumbs=array(
	'Program Updates'=>array('index'),
	$model->Name=>array('view','id'=>$model->Name),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProgramUpdates', 'url'=>array('index')),
	array('label'=>'Create ProgramUpdates', 'url'=>array('create')),
	array('label'=>'View ProgramUpdates', 'url'=>array('view', 'id'=>$model->Name)),
	array('label'=>'Manage ProgramUpdates', 'url'=>array('admin')),
);
?>

    <h1>Update ProgramUpdates <?php echo $model->Name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>