<?php
/* @var $this ProgrammeController */
/* @var $model Programme */


$this->breadcrumbs=array(
	'Programme'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Programme', 'url'=>array('index')),
	array('label'=>'Create Programme', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#programme-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");



?>

<h1>Manage Programmes</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'id'=>'programme-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ID',
		'Name',
		'Downloads',
		'Kategorie',
		'Sterne',
		'enabled',
		/*
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
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>