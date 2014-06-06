<?php
/* @var $this MsMainController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
	'Login',
);
?>

<div class="container">

	<?php echo MsHtml::pageHeader("Login", ""); ?>

	<div class="well">

		<p>Please fill out the following form with your login credentials:</p>

		<div class="form">
			<?php $form = $this->beginWidget('TbActiveForm', array(
				'id' => 'login-form',
				'enableClientValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
				),
			)); ?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<div>
				<?php echo $form->labelEx($model, 'username'); ?>
				<?php echo $form->textField($model, 'username'); ?>
				<?php echo $form->error($model, 'username'); ?>
			</div>

			<div>
				<?php echo $form->labelEx($model, 'password'); ?>
				<?php echo $form->passwordField($model, 'password'); ?>
				<?php echo $form->error($model, 'password'); ?>
			</div>

			<div class="rememberMe">
				<?php echo $form->checkBox($model, 'rememberMe'); ?>
				<?php echo $form->label($model, 'rememberMe'); ?>
				<?php echo $form->error($model, 'rememberMe'); ?>
			</div>

			<div class="buttons">
				<?php echo MsHtml::submitButton('Login'); ?>
			</div>

			<?php $this->endWidget(); ?>
		</div> <!-- form -->

	</div> <!-- Well -->

</div><!-- Container -->