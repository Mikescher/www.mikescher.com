<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ID',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'Date',array('span'=>5)); ?>

                    <?php echo $form->textAreaControlGroup($model,'Content',array('rows'=>6,'span'=>8)); ?>

					<?php echo $form->textFieldControlGroup($model,'ControllerID',array('span'=>5)); ?>

					<?php echo $form->textFieldControlGroup($model,'Visible',array('span'=>5)); ?>

					<?php echo $form->textFieldControlGroup($model,'Enabled',array('span'=>5)); ?>


	<div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->