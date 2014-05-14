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

	<?php echo TbHtml::pageHeader('About Mikescher.de', ''); ?>


	<p>Welcome to my private homepage.</p>

	<p>My name is Mike Schwörer, and this is my homepage - here i upload programs i write in my free time and sometimes i even write a blog entry ...'); </p>

	<p>If you want you can look <?php echo TbHtml::link('here', '#'); // TODO Add Link ?> at the things I programmed </p>

	<?php echo TbHtml::well( file_get_contents('protected/data/disclaimer.php') ); ?>

	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL)); ?>

	<div class="well cstm-background-white">
	<fieldset>
		<legend>Contact Me</legend>

		<?php
		echo TbHtml::textFieldControlGroup('name', '',
		[
			'label' => 'Name:',
			'placeholder' => 'Name'
		]);

		echo TbHtml::textFieldControlGroup('email', '',
		[
			'label' => 'Email address:',
			'placeholder' => 'Email'
		]);

		echo TbHtml::textFieldControlGroup('header', '',
		[
			'label' => 'Title:',
			'placeholder' => 'Header'
		]);

		echo TbHtml::textAreaControlGroup('text', '',
		[
			'label' => 'Message:',
			'rows' => 6
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
		]);
	?>

	<?php $this->endWidget(); ?>
	</div>
</div>