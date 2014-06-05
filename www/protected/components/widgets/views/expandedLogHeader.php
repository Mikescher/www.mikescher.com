<?php
/* @var $this ExpandedLogHeader */
?>

<div class="expCollHeader">

	<?php echo MsHtml::collapsedHeader($this->date, $this->caption, $this->link); ?>

	<div class="expCollContent">
		<p>
			<?php echo $this->content; ?>
		</p>
	</div>
</div>