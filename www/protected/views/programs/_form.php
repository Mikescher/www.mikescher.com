<?php
/* @var $this ProgramController */
/* @var $model Program */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'program-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textAreaControlGroup($model,'Name',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'Downloads',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'Kategorie',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'Sterne',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'enabled',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'visible',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'Language',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'Description',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'add_date',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'download_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'viewable_code',array('span'=>5)); ?>

            <?php echo $form->textAreaControlGroup($model,'sourceforge_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'homepage_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'github_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'uses_absCanv',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'update_identifier',array('span'=>5,'maxlength'=>28)); ?>

            <?php echo $form->textFieldControlGroup($model,'highscore_gid',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->