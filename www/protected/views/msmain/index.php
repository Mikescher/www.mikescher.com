<?php
/* @var $this MsMainController */
/* @var $program Program */
/* @var $logs Log[] */

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

	$i = 0;
	foreach ($logs as $logelem) {
		if ($i == 0) {
			$this->widget('ExpandedLogHeader',
				[
					'date' => $logelem->getDateTime(),
					'caption' => $logelem->title,
					'link' => '',
					'content' => $logelem->content,
				]);
		} else {
			echo MsHtml::collapsedHeader($logelem->getDateTime(), $logelem->title, $logelem->getLink());
		}

		$i++;
	}

	?>

</div>