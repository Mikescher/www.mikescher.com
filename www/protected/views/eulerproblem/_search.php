<?php
/* @var $this EulerProblemController */
/* @var $model EulerProblem */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'Problemnumber',array('span'=>5)); ?>

					<?php echo $form->textFieldControlGroup($model,'Problemtitle',array('span'=>5,'maxlength'=>50)); ?>

                    <?php echo $form->textAreaControlGroup($model,'Problemdescription',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'Code',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'Explanation',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'AbbreviatedCode',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'SolutionSteps',array('span'=>5,'maxlength'=>20)); ?>

					<?php echo $form->textFieldControlGroup($model,'SolutionTime',array('span'=>5,'maxlength'=>20)); ?>

					<?php echo $form->textFieldControlGroup($model,'SolutionWidth',array('span'=>5)); ?>
					<?php echo $form->textFieldControlGroup($model,'SolutionHeight',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'SolutionValue',array('span'=>5,'maxlength'=>20)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->