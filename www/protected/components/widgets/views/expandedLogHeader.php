<?php
/* @var $this ExpandedLogHeader */
?>

<div class="expCollHeader">

	<?php echo MsHtml::collapsedHeader($this->date, $this->caption, $this->link); ?>

	<div class="expCollContent markdownOwner">
		<p>
			<?php

			$this->beginWidget('CMarkdown');

				echo file_get_contents('protected/components/widgets/views/demo.md');

			$this->endWidget();

			?>

			<?php //echo $this->content; ?>
		</p>
	</div>
</div>