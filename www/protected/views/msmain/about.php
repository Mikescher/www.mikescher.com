<?php
/* @var $this MsMainController */

$this->pageTitle=Yii::app()->name;

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

		<p>My name is Mike Schwörer, and this is my homepage - here i upload program i write in my free time and sometimes i even write a blog entry. </p>

		<p>If you want you can look <?php echo MsHtml::link('here', '/programs'); ?> at the things I programd </p>
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
					'size' => MsHtml::INPUT_SIZE_XXLARGE,
					'prepend' => MsHtml::icon(MsHtml::ICON_USER),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'email',
				[
					'placeholder' => 'Email address',
					'size' => MsHtml::INPUT_SIZE_XXLARGE,
					'prepend' => MsHtml::icon(MsHtml::ICON_ENVELOPE),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'header',
				[
					'placeholder' => 'Header',
					'size' => MsHtml::INPUT_SIZE_XXLARGE,
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