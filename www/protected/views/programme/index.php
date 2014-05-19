<?php
/* @var $this ProgrammeController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Programme',
);

$this->menu=array(
	array('label'=>'Create Programme','url'=>array('create')),
	array('label'=>'Manage Programme','url'=>array('admin')),
);
?>

<h1>Programmes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>