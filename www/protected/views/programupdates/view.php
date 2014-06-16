<?php
/* @var $this ProgramUpdatesController */
/* @var $model ProgramUpdates */
?>

<?php
$this->breadcrumbs = array(
	'Program Updates' => array('index'),
	$model->Name,
);

$this->menu = array(
	array('label' => 'List ProgramUpdates', 'url' => array('index')),
	array('label' => 'Create ProgramUpdates', 'url' => array('create')),
	array('label' => 'Update ProgramUpdates', 'url' => array('update', 'id' => $model->Name)),
	array('label' => 'Delete ProgramUpdates', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->Name), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage ProgramUpdates', 'url' => array('admin')),
);
?>

	<h1><?php echo $model->Name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'htmlOptions' => array(
		'class' => 'table table-striped table-condensed table-hover',
	),
	'data' => $model,
	'attributes' => array(
		'Name',
		'Version',
		'Link',
	),
)); ?>

<h3>Request-Log</h3>

<?php

	$this->widget('bootstrap.widgets.TbGridView', array(
		'type' => TbHtml::GRID_TYPE_CONDENSED,
		'dataProvider' => new CArrayDataProvider($model->log, ['keyField' => 'ID','Pagination' => ['PageSize' => 100]]),

		'columns' => array(
			[
				'header' => 'ID',
				'value' => '$data->ID',
			],
			[
				'header' => 'Programname',
				'value' => '$data->programname',
			],
			[
				'header' => 'IP',
				'value' => '$data->ip',
			],
			[
				'header' => 'Version',
				'value' => '$data->version',
			],
			[
				'header' => 'Date',
				'value' => '$data->date',
			],
		),

	));
?>