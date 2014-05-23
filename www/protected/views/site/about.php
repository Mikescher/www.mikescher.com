<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->breadcrumbs=
	[
		'About'
	];

$this->selectedNav = 'about';

?>

<div class="container">

	<?php if (isset($alerts_success)) foreach($alerts_success as $alert) echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, $alert); ?>
	<?php if (isset($alerts_error)) foreach($alerts_error as $alert) echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $alert); ?>

	<?php echo TbHtml::pageHeader('About Mikescher.de', ''); ?>

	<div class="well cstm-well-light">
		<p>Welcome to my private homepage.</p>

		<p>My name is Mike Schwörer, and this is my homepage - here i upload programs i write in my free time and sometimes i even write a blog entry. </p>

		<p>If you want you can look <?php echo TbHtml::link('here', '#'); // TODO Add Link ?> at the things I programmed </p>
	</div>

	<div class="well cstm-well-light">
		<?php
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
			[
				'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL
			]);
		?>

		<fieldset>
			<legend>Contact</legend>
			<?php
			echo $form->textFieldControlGroup($model, 'name',
				[
					'placeholder' => 'Name',
					'size' => TbHtml::INPUT_SIZE_XXLARGE,
					'prepend' => TbHtml::icon(TbHtml::ICON_USER),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'email',
				[
					'placeholder' => 'Email address',
					'size' => TbHtml::INPUT_SIZE_XXLARGE,
					'prepend' => TbHtml::icon(TbHtml::ICON_ENVELOPE),
					'span' => 2,
				]);
			echo $form->textFieldControlGroup($model, 'header',
				[
					'placeholder' => 'Header',
					'size' => TbHtml::INPUT_SIZE_XXLARGE,
					'prepend' => TbHtml::icon(TbHtml::ICON_TAG),
					'span' => 5,
				]);
			echo $form->textAreaControlGroup( $model, 'message',
				[
					'placeholder' => 'Message',
					'size' => TbHtml::INPUT_SIZE_XXLARGE,
					'rows' => 10,
				]);
			?>
		</fieldset>

		<?php echo TbHtml::formActions(
			[
				TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				TbHtml::resetButton('Reset'),
			],
			[
				'class' => 'cstm-background-white',
			]); ?>

		<?php $this->endWidget(); ?>
	</div>

	<?php echo TbHtml::well( file_get_contents('protected/data/disclaimer.php') ); ?>

</div>