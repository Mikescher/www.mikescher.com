<?php
/* @var $this MsMainController */

$this->pageTitle = 'About - ' . Yii::app()->name;

$this->breadcrumbs=
	[
		'About'
	];

$this->selectedNav = 'about';

?>

<div class="container">

	<?php if (isset($alerts_success)) foreach($alerts_success as $alert) echo MsHtml::alert(MsHtml::ALERT_COLOR_SUCCESS, $alert); ?>
	<?php if (isset($alerts_error)) foreach($alerts_error as $alert) echo MsHtml::alert(MsHtml::ALERT_COLOR_ERROR, $alert); ?>

	<?php echo MsHtml::pageHeader('About Mikescher.de', ''); ?>

	<div class="well cstm-well-light">
		<p>Welcome to my private homepage.</p>

		<p>My name is Mike Schwörer, and this is my homepage. Mainly I will upload my programs here and sometimes I write something for my blog </p>

		<p>If you want you can look <?php echo MsHtml::link('here', '/programs'); ?> at the things I programmed </p>
	</div>

	<?php $egh = (new ExtendedGitGraph('Mikescher'))->loadFinishedData(); ?>
	<div class="gitbox-container">
		<div class="gitbox-header">My Github Commits</div>

		<?php echo $egh['content']; ?>

		<div class="gitbox-footer">
			<div class="gitbox-footer-box">
				<span class="gitbox-footer-box-header">Last Update</span>
				<span class="gitbox-footer-box-number"><?php echo $egh['creation']->diff(new DateTime())->days + 1; ?> day<?php echo (($egh['creation']->diff(new DateTime())->days == 0) ? '' : 's')?> ago</span>
				<span class="gitbox-footer-box-footer"><?php echo $egh['creation']->format('M d Y'); ?></span>
			</div>

			<div class="gitbox-footer-box">
    			<span class="gitbox-footer-box-header">Total commits</span>
    			<span class="gitbox-footer-box-number"><?php echo $egh['total'] ?></span>
				<span class="gitbox-footer-box-footer"><?php echo $egh['start']->format('M d Y') . ' - ' . $egh['end']->format('M d Y'); ?></span>
			</div>

			<div class="gitbox-footer-box">
				<span class="gitbox-footer-box-header">Longest streak</span>
				<span class="gitbox-footer-box-number"><?php echo $egh['streak']; ?> day<?php echo (($egh['streak'] == 1) ? '' : 's'); ?></span>
				<span class="gitbox-footer-box-footer"><?php echo $egh['streak_start']->format('M d Y') . ' - ' . $egh['streak_end']->format('M d Y'); ?></span>
			</div>

			<div class="gitbox-footer-box">
				<span class="gitbox-footer-box-header">Max commits</span>
				<span class="gitbox-footer-box-number"><?php echo $egh['max_commits']; ?> / day</span>
				<span class="gitbox-footer-box-footer"><?php echo $egh['max_commits_date']->format('M d Y'); ?></span>
			</div>

			<div class="gitbox-footer-box">
				<span class="gitbox-footer-box-header">Avg commits</span>
				<span class="gitbox-footer-box-number"><?php echo number_format($egh['avg_commits'], 2); ?> / day</span>
				<span class="gitbox-footer-box-footer"><?php echo $egh['start']->format('M d Y') . ' - ' . $egh['end']->format('M d Y'); ?></span>
			</div>
		</div>
	</div>

	<div class="well cstm-well-light">
		<?php
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
			[
				'layout' => MsHtml::FORM_LAYOUT_HORIZONTAL
			]);
		?>


		<fieldset>
			<legend>Contact</legend>
			<?php
			echo $form->textFieldControlGroup($model, 'name',
				[
					'placeholder' => 'Name',
					'size' => MsHtml::INPUT_SIZE_CUSTOM_ABOUTTXT,
					'prepend' => MsHtml::icon(MsHtml::ICON_USER),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'email',
				[
					'placeholder' => 'Email address',
					'size' => MsHtml::INPUT_SIZE_CUSTOM_ABOUTTXT,
					'prepend' => MsHtml::icon(MsHtml::ICON_ENVELOPE),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'header',
				[
					'placeholder' => 'Header',
					'size' => MsHtml::INPUT_SIZE_CUSTOM_ABOUTTXT,
					'prepend' => MsHtml::icon(MsHtml::ICON_TAG),
					'span' => 5,
				]);
			echo $form->textAreaControlGroup( $model, 'message',
				[
					'placeholder' => 'Message',
					'size' => MsHtml::INPUT_SIZE_XXLARGE,
					'rows' => 10,
				]);
			?>
		</fieldset>

		<?php echo MsHtml::formActions(
			[
				MsHtml::submitButton('Submit', array('color' => MsHtml::BUTTON_COLOR_PRIMARY)),
				MsHtml::resetButton('Reset'),
			],
			[
				'class' => 'cstm-background-white',
			]); ?>

		<?php $this->endWidget(); ?>
	</div>

	<?php echo MsHtml::well( file_get_contents('protected/data/disclaimer.php') ); ?>

</div>
