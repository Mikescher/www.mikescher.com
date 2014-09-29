<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */


$this->breadcrumbs=array(
	'Euler Problems'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EulerProblem', 'url'=>array('index')),
	array('label'=>'Create EulerProblem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#euler-problem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Euler Problems</h1>

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
	'id'=>'euler-problem-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Problemnumber',
		'Problemdescription',
		'Code',
		'Explanation',
		'AbbreviatedCode',
		'SolutionSteps',
		/*
		'SolutionTime',
		'SolutionValue',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>