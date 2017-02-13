<?php
/* @var $this MsMainController */
?>

<?php

$this->pageTitle = 'Admin Panel - ' . Yii::app()->name;

$this->breadcrumbs =
	[
		'Admin',
	];

array_push($this->js_files, '/javascript/msmain_admin_script.js');

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

	<div class="row">
		<div class="span3">
			<?php
			echo MsHtml::lead('EulerProblems');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Manage', 'url' => '/eulerproblem/admin'],
					['label' => 'Create', 'url' => '/eulerproblem/create'],
				]
			); ?>
		</div>

		<div class="span3" style="visibility: hidden">
			<?php
			echo MsHtml::lead('xxx');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/xxx'],
					['label' => 'Manage', 'url' => '/xxx/admin'],
					['label' => 'Create', 'url' => '/xxx/create'],
				]
			); ?>
		</div>

		<div class="span3" style="visibility: hidden">
			<?php
			echo MsHtml::lead('xxx');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/xxx'],
					['label' => 'Manage', 'url' => '/xxx/admin'],
					['label' => 'Create', 'url' => '/xxx/create'],
				]
			); ?>
		</div>

		<div class="span3" style="visibility: hidden">
			<?php
			echo MsHtml::lead('xxx');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show', 'url' => '/xxx'],
					['label' => 'Manage', 'url' => '/xxx/admin'],
					['label' => 'Create', 'url' => '/xxx/create'],
				]
			); ?>
		</div>
	</div>

	<div class="well well-small">
		<?php
		if (file_exists('protected/data/git_graph_data.dat'))
		{
			$egh = $egh = (new ExtendedGitGraph('Mikescher'))->loadFinishedData();
		}
		else
		{
			$egh = null;
		}
		
		?>

		<h2>ExtendedGitGraph</h2>
		<hr>

		<strong>Last Update: </strong> <?php if ($egh != null) { echo $egh['creation']->format('d.m.Y H:i'); } ?> <br>
		<strong>Repositories: </strong> <?php if ($egh != null) {  echo $egh['repos']; } ?> <br>
		<strong>Commits: </strong> <?php if ($egh != null) {  echo $egh['total']; } ?> <br>

		<br><br>

		<div style="text-align: center;">
		<textarea id="egh_ajaxOutput" readonly="readonly"></textarea>
		<br>
		<a class="btn btn-primary" href="javascript:startAjaxRefresh()" style="width: 90%"> Update </a>
		</div>


	</div>

	<div class="well well-small">
		<h2>Linklist</h2>
		<hr>

		<ul>
			<!--<li><a href="https://mikescher-de.disqus.com">Disqus Admin Panel</a></li>-->
			<li><a href="https://www.strato.de/apps/CustomerService">Strato Customer Service</a></li>
			<li><a href="http://v1.mikescher.com">Mikescher Wayback (v1)</a></li>
			<li><a href="http://v2.mikescher.com">Mikescher Wayback (v2)</a></li>
			<li><a href="http://v3.mikescher.com">Mikescher Wayback (v3)</a></li>
		</ul>
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

	<div class="well well-small">
		<h2>Hit counter</h2>

		<hr>

		<?php
			/* @var CHitCounter $hc */
			$hc = Yii::app()->hitcounter;
		?>

		<strong>Hits (today):</strong> <?php echo $hc->getTodayCount(); ?><br />
		<strong>Hits (total):</strong> <?php echo $hc->getTotalCount(); ?><br />

		<hr>
		
		<?php

		$data = array();

		$now = new DateTime();

		for ($i = 0; $i < 24; $i++) {
			$data[] =
				[
					'Date' => $now->format('d.m.Y :: D'),
					'Count' => $hc->getCountForDay($now),
				];

			$now->modify('-1 day');
		}

		$this->widget('bootstrap.widgets.TbGridView',
			[
				'type' => TbHtml::GRID_TYPE_CONDENSED,
				'dataProvider' => new CArrayDataProvider($data,
						[
							'keyField' => 'Date',
							'Pagination' =>
								[
									'PageSize' => 100,
								]
						]),
			]
		); ?>
	</div>
</div>