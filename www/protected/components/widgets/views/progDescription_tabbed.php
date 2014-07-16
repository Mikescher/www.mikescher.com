<?php
/* @var $this ProgDescription */
/* @var $name string */
/* @var $descriptions array() */
?>


<div class="progview_maincol">
	<div class="progview_caption" >
		<h1 class="text-center"><?php echo $name; ?></h1>
	</div>

	<?php
	$this->widget('bootstrap.widgets.TbTabs',
		[
			'tabs' => ProgramHelper::convertDescriptionListToTabs($descriptions, $name),
		]
	);
	?>
</div>