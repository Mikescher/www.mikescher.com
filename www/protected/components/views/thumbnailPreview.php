<?php
/* @var $this ThumbnailPreview */
?>

<li class="span3 thumbnailParentSpan">
	<div >
		<div class="thumbnail <?php if (! $this->enabled) print("thumbnailDisabled"); ?>">
			<div class="thumbnailInnerHead">
				<a <?php if($this->enabled) echo 'href="'. $this->link . '"'; ?>>
					<img style="width: 100%" src="<?php echo $this->image; ?>">
				</a>
			</div>
			<div class="caption">
				<?php $h_level = (strlen($this->caption) > 13) ? ["<h3>", "</h3>"] : ["<h2>", "</h2>"]; ?>

				<?php echo $h_level[0]; ?>

				<?php
					if ($this->enabled)
						echo '<a class="progThumbnailCaption" href="' . $this->link . '">' . $this->caption . '</a>';
					else
						echo '<a class="progThumbnailCaption">' . $this->caption . '</a>';
				?>

				<?php echo $h_level[1]; ?>

				<p class="thumbnailInnerDescription">
					<?php echo $this->description; ?>
				</p>

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