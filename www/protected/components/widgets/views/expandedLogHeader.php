<?php
/* @var $this ExpandedLogHeader */
?>

<div class="expCollHeader accordion-group">

	<?php
		if ($this->isCollapsable()) {
			echo MsHtml::interactiveCollapsedHeader($this->date, $this->caption, $this->collapseOwner, '#' . $this->getContentID());
		} else {
			echo MsHtml::collapsedHeader($this->date, $this->caption, $this->link);
		}
	?>

	<div <?php echo $this->getContentTagDefinition(); ?>>
		<div>
			<p>
				<?php

				$this->beginWidget('CMarkdown');

				echo $this->content;

				$this->endWidget();

				?>
			</p>
		</div>
	</div>
</div>