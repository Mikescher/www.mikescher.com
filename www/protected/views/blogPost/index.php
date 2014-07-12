<?php
/* @var $this BlogPostController */
/* @var $blogposts BlogPost[] */
?>

<?php

$this->pageTitle = 'Blog - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'Blog' => array('/blog'),
);

$this->selectedNav = 'blog';

?>

<div class="container">

	<?php echo MsHtml::pageHeader("Blog", "My personal programming blog"); ?>

	<?php
	$i = 0;
	foreach($blogposts as $blogpost) {
		$i++;

		$this->widget('BlogLink',
			[
				'date' => new DateTime($blogpost->Date),
				'caption' => $blogpost->Title,
				'link' => $blogpost->getLink(),
			]);
	}
	?>

</div>