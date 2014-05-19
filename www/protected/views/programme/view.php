<?php
/* @var $this ProgrammeController */
/* @var $model Programme */
?>

<?php
$this->breadcrumbs=array(
	'Programme'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Programme', 'url'=>array('index')),
	array('label'=>'Create Programme', 'url'=>array('create')),
	array('label'=>'Update Programme', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Programme', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Programme', 'url'=>array('admin')),
);
?>

<h1>View Programme #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'ID',
		'Name',
		'Downloads',
		'Kategorie',
		'Sterne',
		'enabled',
		'visible',
		'Language',
		'Description',
		'add_date',
		'download_url',
		'viewable_code',
		'sourceforge_url',
		'homepage_url',
		'github_url',
		'uses_absCanv',
		'update_identifier',
		'highscore_gid',
	),
)); ?>