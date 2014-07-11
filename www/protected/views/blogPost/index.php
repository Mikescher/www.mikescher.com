<?php
/* @var $this BlogPostController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php

$this->pageTitle = 'Blog - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'Blog' => array('/blog'),
);

$this->selectedNav = 'blog';

?>

<h1>Blog Posts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>