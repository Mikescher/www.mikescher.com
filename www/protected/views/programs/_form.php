<?php
/* @var $this ProgramsController */
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

            <?php echo $form->textFieldControlGroup($model,'Name',array('rows'=>6,'span'=>8)); ?>

			<?php echo $form->textFieldControlGroup($model,'Thumbnailname',array('rows'=>6,'span'=>8)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'Downloads',array('span'=>5, 'value' => '0'));
			else
				echo $form->textFieldControlGroup($model,'Downloads',array('span'=>5, ));
			?>

            <?php echo $form->textFieldControlGroup($model,'Kategorie',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'Sterne',array('span'=>5)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'enabled',array('span'=>5, 'value' => '0'));
			else
				echo $form->textFieldControlGroup($model,'enabled',array('span'=>5, ));
			?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'visible',array('span'=>5, 'value' => '0'));
			else
				echo $form->textFieldControlGroup($model,'visible',array('span'=>5, ));
			?>

            <?php echo $form->textFieldControlGroup($model,'Language',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'Description',array('rows'=>6,'span'=>8)); ?>

			<?php echo $form->textFieldControlGroup($model,'programming_lang',array('rows'=>6,'span'=>8)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'add_date',array('span'=>5, 'value' => date('Y-m-d')));
			else
				echo $form->textFieldControlGroup($model,'add_date',array('span'=>5, ));
			?>

            <?php echo $form->textFieldControlGroup($model,'download_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'sourceforge_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'homepage_url',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textFieldControlGroup($model,'github_url',array('rows'=>6,'span'=>8)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'uses_absCanv',array('span'=>5, 'value' => date('Y-m-d')));
			else
				echo $form->textFieldControlGroup($model,'uses_absCanv',array('span'=>5, ));
			?>

            <?php echo $form->textFieldControlGroup($model,'update_identifier',array('span'=>5,'maxlength'=>28)); ?>

            <?php echo $form->textFieldControlGroup($model,'highscore_gid',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo MsHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>MsHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>MsHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->