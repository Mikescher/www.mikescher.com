<?php
/* @var $this ProgrammeController */
/* @var $model Programme */
?>

<?php
$this->breadcrumbs=array(
	'Programmes'=>array('index'),
	$model->Name=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Programme', 'url'=>array('index')),
	array('label'=>'Create Programme', 'url'=>array('create')),
	array('label'=>'View Programme', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage Programme', 'url'=>array('admin')),
);
?>

    <h1>Update Programme <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>