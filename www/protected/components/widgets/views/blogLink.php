<?php
/* @var $this BlogLink */
?>

<div class="row collHeader collHeaderLinkParent">
	<div class="collHeaderSpan-front"><?php echo $this->date->format('d.m.Y'); ?></div>
	<div class="collHeaderSpan"><?php echo $this->caption; ?></div>
	<div class="collHeaderSpan-drop"><i class="icon-file" ></i></div>
	<a class="collHeaderLink" href="<?php echo $this->link; ?>">&nbsp;</a>
</div>