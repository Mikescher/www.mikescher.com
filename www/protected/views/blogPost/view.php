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

	<?php echo MsHtml::pageHeader("Blog", "My personal programming blog"); ?>

	<div class="blogOwner well markdownOwner" id="markdownAjaxContent">
		<?php echo ParsedownHelper::parse($model->Content); ?>

		<div class="blogFooter">
			<div class="blogFooterLeft">
				<?php echo $model->Title; ?>
			</div>
			<div class="blogFooterRight">
				<?php echo $model->getDateTime()->format('d.m.Y'); ?>
			</div>
		</div>
	</div>

</div>
