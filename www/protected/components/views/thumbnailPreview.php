<?php
/* @var $this ThumbnailPreview */
?>

<li class="span3" style="width: 270px">
	<div style="min-height: 600px">
		<div class="thumbnail" style="padding: 0;">
			<div style="padding:4px; height: 225px; overflow-y: hidden">
				<img style="width: 100%" src="<?php echo $this->image; ?>">
			</div>
			<div class="caption">
				<?php //TODO Line out css to styles.css !!!!
				if ( strlen($this->caption) > 13)
					echo '<h3 class="progThumbnailCaption">' . $this->caption . '</h3>';
				else
					echo '<h2 class="progThumbnailCaption">' . $this->caption . '</h2>';
				?>

				<p style="min-height: 70px;"><?php echo $this->description; ?></p>

				<p>
					<?php
					if (!empty($this->category)) {
						echo TbHtml::icon(TbHtml::ICON_TAG);
						echo $this->category . '';
					}
					?>
				</p>

				<p>
					<?php
					foreach ($this->language as $lang) {
						echo TbHtml::icon(TbHtml::ICON_GLOBE);
						echo $lang;
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					?>
			</div>
			<div class="modal-footer" style="text-align: left">
				<div class="text-center">
					<?php
					for ($i = 0; $i < 4; $i++) {
						if ($i < $this->starcount)
							echo TbHtml::icon(TbHtml::ICON_STAR);
						else
							echo TbHtml::icon(TbHtml::ICON_STAR_EMPTY);
					}
					?>
				</div>
				<br>

				<div class="row-fluid">
					<div class="span4"><b><?php echo $this->downloads; ?></b><br/>
						<small>Downloads</small>
					</div>
					<div class="span4"><b><?php echo $this->date->format('d.m.y'); ?></b><br/>
						<small>Added On</small>
					</div>
					<div class="span4"><b><?php echo $this->starcount . '/4'; ?></b><br/>
						<small>Rating</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>