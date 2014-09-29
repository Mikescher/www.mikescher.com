<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'euler-problem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

			<?php echo $form->textFieldControlGroup($model,'Problemnumber',array('span'=>8)); ?>

			<?php echo $form->textFieldControlGroup($model,'Problemtitle',array('span'=>5,'maxlength'=>50)); ?>

            <?php echo $form->textAreaControlGroup($model,'Problemdescription',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'Code',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'Explanation',array('rows'=>6,'span'=>8)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'AbbreviatedCode',array('span'=>5, 'value' => '0'));
			else
				echo $form->textFieldControlGroup($model,'AbbreviatedCode',array('span'=>5));
			?>

            <?php echo $form->textFieldControlGroup($model,'SolutionSteps',array('span'=>5,'maxlength'=>20)); ?>

            <?php echo $form->textFieldControlGroup($model,'SolutionTime',array('span'=>5,'maxlength'=>20)); ?>

			<?php echo $form->textFieldControlGroup($model,'SolutionWidth',array('span'=>5)); ?>
			<?php echo $form->textFieldControlGroup($model,'SolutionHeight',array('span'=>5)); ?>

            <?php echo $form->textFieldControlGroup($model,'SolutionValue',array('span'=>5,'maxlength'=>20)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->