<?php
/* @var $this MsMainController */
?>

<?php
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
			echo MsHtml::lead('Programs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show',    'url' => '/log'],
					['label' => 'Manage',  'url' => '/log/admin'],
					['label' => 'Create',  'url' => '/log/create'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('Logs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Show',    'url' => '/programs'],
					['label' => 'Manage',  'url' => '/programs/admin'],
					['label' => 'Create',  'url' => '/programs/create'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('Programs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Home',     'url' => '#'],
					['label' => 'Profile',  'url' => '#'],
					['label' => 'Messages', 'url' => '#'],
				]
			); ?>
		</div>

		<div class="span3">
			<?php
			echo MsHtml::lead('Programs');

			echo MsHtml::stackedTabs(
				[
					['label' => 'Home',     'url' => '#'],
					['label' => 'Profile',  'url' => '#'],
					['label' => 'Messages', 'url' => '#'],
				]
			); ?>
		</div>
	</div>
</div>