<?php
/* @var $this MsMainController */
/* @var $program Program */

$this->pageTitle=Yii::app()->name;

$this->breadcrumbs=
	[
		'Index'
	];

$this->selectedNav = 'index';

?>

<div class="container">

	<!-- Main hero unit for a primary marketing message or call to action -->

	<?php
	$this->widget('FullProgPreview',
		[
			'caption' => "Program of the Day:",
			'program' => $program,
		]);
	?>

	<?php
	$this->widget('ExpandedLogHeader',
		[
			'date' => new DateTime(),
			'caption' => 'test',
			'link' => '#',
			'content' =>
				'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
				dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
				Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
				amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
				aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
				gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
		]);
	?>


	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World", "/log/1"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

</div>