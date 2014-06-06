<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'date',array('span'=>5, 'value'=>date('Y-m-d'))); ?>

            <?php echo $form->textAreaControlGroup($model,'title',array('rows'=>6,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'content',array('rows'=>6,'span'=>8)); ?>

			<?php echo MsHtml::ajaxButton ("Preview", CController::createUrl('log/ajaxMarkdownPreview'),
				[
					'type'=>'POST',
					'data' => ['content'=> 'js: $("#Log_content").val()'],
					'update' => '#markdownAjaxContent',
                	'error'=>'function(msg){alert("An error has happened");}',
				]); ?>

			<br>
			<br>

			<div class="well markdownOwner" id="markdownAjaxContent">
				<?php $this->renderPartial('_ajaxMarkdownPreview', ['content' => $model->content, ], false, true); ?>
			</div>

        <div class="form-actions">
        <?php echo MsHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>MsHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>MsHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->