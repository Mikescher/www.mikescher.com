<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
?>

<?php

$this->pageTitle = 'Blogpost: ' . $model->Title . ' - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'Blog' => array('/blog'),
	$model->Title,
);
?>

<div class="container">

	<h1>View BlogPost #<?php echo $model->ID; ?></h1>

	<div class="well markdownOwner" id="markdownAjaxContent">
		<?php echo ParsedownHelper::parse($model->Content); ?>
	</div>

</div>
