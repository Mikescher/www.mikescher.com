<?php
/* @var $this ProgDescription */
/* @var $name string */
/* @var $descriptions array() */
?>


<div class="well progview_maincol">
	<div class="progview_caption" >
		<h1 class="text-center"><?php echo $name; ?></h1>
	</div>

	<?php
	echo ProgramHelper::getDescriptionMarkdownTab($descriptions[0]['path']);
	?>
</div>