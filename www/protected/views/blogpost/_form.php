<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'blog-post-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'Date',array('span'=>5, 'value' => date('Y-m-d')));
			else
				echo $form->textFieldControlGroup($model,'Date',array('span'=>5, ));
			?>

			<?php echo $form->textFieldControlGroup($model,'Title',array('span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'Content',array('rows'=>30,'span'=>8)); ?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'Visible',array('span'=>5, 'value' => '1'));
			else
				echo $form->textFieldControlGroup($model,'Visible',array('span'=>5, ));
			?>

			<?php
			if ($model->isNewRecord)
				echo $form->textFieldControlGroup($model,'Enabled',array('span'=>5, 'value' => '1'));
			else
				echo $form->textFieldControlGroup($model,'Enabled',array('span'=>5, ));
			?>

			<?php echo MsHtml::ajaxButton ("Preview", CController::createUrl('blog/ajaxMarkdownPreview'),
				[
					'type'=>'POST',
					'data' => ['Content' => 'js: $("#BlogPost_Content").val()'],
					'update' => '#markdownAjaxContent',
					'error'=>'function(msg){alert("An error has happened" + JSON.stringify(msg));}',
				]); ?>

			<br>
			<br>

			<div class="well markdownOwner" id="markdownAjaxContent">
				<?php $this->renderPartial('_ajaxMarkdownPreview', ['Content' => $model->Content, ], false, true); ?>
			</div>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->