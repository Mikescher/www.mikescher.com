<?php
/* @var $this MsMainController */
/* @var $logs Log[] */
/* @var $logid integer */

$this->pageTitle=Yii::app()->name;

$this->breadcrumbs=
	[
		'Log'
	];

$this->selectedNav = '';

?>

<div class="container">

	<?php echo MsHtml::pageHeader("Site-log", "Changelog and Blog for mikescher.de"); ?>

	<div class="accordion" id="lca">
		<?php
		$i = 0;
		foreach($logs as $logelem) { //TODO-MS Translate all log things to eng
			$i++;

			$this->widget('ExpandedLogHeader',
				[
					'date' => new DateTime($logelem->date),
					'caption' => $logelem->title,
					'content' => $logelem->content,
					'collapseID' => $i,
					'collapseOwner' => '#lca',
					'collapseOpen' => ($logelem->ID == $logid),
				]);
		}
		?>
	</div>

</div>