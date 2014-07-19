<?php
/* @var $this MsMainController */
?>

<?php

$this->pageTitle = 'Manage - ' . Yii::app()->name;

$this->breadcrumbs =
	[
		'Admin',
	];
?>

<div class="container">
	<?php echo MsHtml::pageHeader("Adminstration", "mikescher.de"); ?>

	<div class="row">
		<div class="span3">
			<?php
			echo MsHtml::lead('Logs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/log'],
					['label' => 'Manage', 'url' => '/log/admin'],
					['label' => 'Create', 'url' => '/log/create'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('Programs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/programs'],
					['label' => 'Manage', 'url' => '/programs/admin'],
					['label' => 'Create', 'url' => '/programs/create'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('ProgramUpdates');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/programupdates'],
					['label' => 'Manage', 'url' => '/programupdates/admin'],
					['label' => 'Create', 'url' => '/programupdates/create'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('BlogPosts');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/blog'],
					['label' => 'Manage', 'url' => '/blog/admin'],
					['label' => 'Create', 'url' => '/blog/create'],
				]
			); ?>
		</div>
	</div>

	<div class="well well-small">
		<?php
		$egh = $egh = (new ExtendedGitGraph('Mikescher'))->loadFinishedData();
		?>

		<h2>ExtendedGitGraph</h2>
		<hr>

		<strong>Last Update: </strong> <?php echo $egh['creation']->format('d.m.Y H:i'); ?> <br>
		<strong>Repositories: </strong> <?php echo $egh['repos']; ?> <br>
		<strong>Commits: </strong> <?php echo $egh['total']; ?> <br>

		<br><br>

		<a class="btn btn-primary" href="?do_egh_update=1"> Update </a>

	</div>

	<div class="well well-small">

		<h2>Program of the day</h2>
		<hr>

		<?php

		$data = array();

		$now = new DateTime();

		for ($i = 0; $i < 100; $i++) {
			$data[] =
				[
					'Date' => $now->format('d.m.Y :: D'),
					'Name' => ProgramHelper::GetDailyProg($now)->Name,
				];

			$now->modify('+1 day');
		}

		$this->widget('bootstrap.widgets.TbGridView',
			[
				'type' => TbHtml::GRID_TYPE_CONDENSED,
				'dataProvider' => new CArrayDataProvider($data,
						[
							'keyField' => 'Date',
							'Pagination' =>
								[
									'PageSize' => 14,
								]
						]),
			]
		); ?>

	</div>
</div>