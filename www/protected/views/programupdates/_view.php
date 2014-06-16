<?php
/* @var $this ProgramUpdatesController */
/* @var $data ProgramUpdates */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Name),array('view','id'=>$data->Name)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Version')); ?>:</b>
	<?php echo CHtml::encode($data->Version); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Link')); ?>:</b>
	<?php echo CHtml::encode($data->Link); ?>
	<br />


</div>