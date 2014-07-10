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

				echo ParsedownHelper::parse($this->content);

				?>
			</p>
		</div>
	</div>
</div>