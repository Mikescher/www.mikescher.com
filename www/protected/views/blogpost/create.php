<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
?>

<?php
$this->breadcrumbs=array(
	'Blog Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BlogPost', 'url'=>array('index')),
	array('label'=>'Manage BlogPost', 'url'=>array('admin')),
);
?>

<h1>Create BlogPost</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>