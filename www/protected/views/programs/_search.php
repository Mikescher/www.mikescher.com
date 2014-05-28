<?php
/* @var $this ProgramController */
/* @var $model Program */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'ID',array('span'=>5)); ?>

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
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->