<?php
/* @var $this ThumbnailPreview */
?>

<li class="span3 thumbnailParentSpan">
	<div >
		<div class="thumbnail">
			<div class="thumbnailInnerHead">
				<a href="<?php echo $this->link; ?>">
					<img style="width: 100%" src="<?php echo $this->image; ?>">
				</a>
			</div>
			<div class="caption">
				<?php
				if ( strlen($this->caption) > 13)
					echo '<h3><a class="progThumbnailCaption" href="' . $this->link . '">' . $this->caption . '</a></h3>';
				else
					echo '<h2><a class="progThumbnailCaption" href="' . $this->link . '">' . $this->caption . '</a></h2>';
				?>

				<p class="thumbnailInnerDescription"><?php echo $this->description; ?></p>

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
			<div class="modal-footer thumbnailInnerFooter">
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