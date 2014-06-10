<?php
/* @var $this ProgramsController */
/* @var $data Program */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID),array('view','id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Thumbnailname')); ?>:</b>
	<?php echo CHtml::encode($data->Thumbnailname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Downloads')); ?>:</b>
	<?php echo CHtml::encode($data->Downloads); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Kategorie')); ?>:</b>
	<?php echo CHtml::encode($data->Kategorie); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sterne')); ?>:</b>
	<?php echo CHtml::encode($data->Sterne); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enabled')); ?>:</b>
	<?php echo CHtml::encode($data->enabled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<?php echo CHtml::encode($data->visible); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Language')); ?>:</b>
	<?php echo CHtml::encode($data->Language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_url')); ?>:</b>
	<?php echo CHtml::encode($data->download_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewable_code')); ?>:</b>
	<?php echo CHtml::encode($data->viewable_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sourceforge_url')); ?>:</b>
	<?php echo CHtml::encode($data->sourceforge_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('homepage_url')); ?>:</b>
	<?php echo CHtml::encode($data->homepage_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('github_url')); ?>:</b>
	<?php echo CHtml::encode($data->github_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uses_absCanv')); ?>:</b>
	<?php echo CHtml::encode($data->uses_absCanv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_identifier')); ?>:</b>
	<?php echo CHtml::encode($data->update_identifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('highscore_gid')); ?>:</b>
	<?php echo CHtml::encode($data->highscore_gid); ?>
	<br />

	*/ ?>

</div>