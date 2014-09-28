<?php
/* @var $this EulerProblemController */
/* @var $data EulerProblem */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('Problemnumber')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Problemnumber),array('view','id'=>$data->Problemnumber)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Problemtitle')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Problemtitle)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Problemdescription')); ?>:</b>
	<?php echo CHtml::encode($data->Problemdescription); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Code')); ?>:</b>
	<?php echo CHtml::encode($data->Code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Explanation')); ?>:</b>
	<?php echo CHtml::encode($data->Explanation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AbbreviatedCode')); ?>:</b>
	<?php echo CHtml::encode($data->AbbreviatedCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SolutionSteps')); ?>:</b>
	<?php echo CHtml::encode($data->SolutionSteps); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SolutionWidth')); ?>:</b>
	<?php echo CHtml::encode($data->SolutionTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SolutionHeight')); ?>:</b>
	<?php echo CHtml::encode($data->SolutionTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SolutionTime')); ?>:</b>
	<?php echo CHtml::encode($data->SolutionTime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('SolutionValue')); ?>:</b>
	<?php echo CHtml::encode($data->SolutionValue); ?>
	<br />

	*/ ?>

</div>