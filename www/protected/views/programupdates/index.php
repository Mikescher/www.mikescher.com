<?php
/* @var $this ProgramUpdatesController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Program Updates',
);

$this->menu=array(
	array('label'=>'Create ProgramUpdates','url'=>array('create')),
	array('label'=>'Manage ProgramUpdates','url'=>array('admin')),
);
?>

<h1>Program Updates</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type'=>'striped bordered condensed',

	'dataProvider'=>$dataProvider,

	'columns'=>array(
		array(
			'name'  => 'Name',
			'value' => 'CHtml::link($data->Name, Yii::app()->createUrl("/programupdates/view",array("id"=>$data->primaryKey)))',
			'type'  => 'raw',
		),
		'Version',
		'Link',
	),
)); ?>