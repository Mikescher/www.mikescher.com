<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
?>

<?php

$this->pageTitle = 'Update Blogpost - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'BlogPosts' => array('index'),
	$model->Title => array('/blog/view/' . $model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List BlogPost', 'url'=>array('index')),
	array('label'=>'Create BlogPost', 'url'=>array('create')),
	array('label'=>'View BlogPost', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage BlogPost', 'url'=>array('admin')),
);
?>

    <h1>Update BlogPost <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>