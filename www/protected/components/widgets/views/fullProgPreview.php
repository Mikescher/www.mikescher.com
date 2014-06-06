<?php
/* @var $this FullProgPreview */
?>

<div class="well fpp_parent">
	<div class="container">

		<h1> <?php echo $this->caption; ?> </h1>

		<br />

		<div class="row">
			<div class="span3">
				<a href="<?php echo $this->program->getLink(); ?>">
					<img class="fpp_previewImg" src="<?php echo $this->program->getImagePath(); ?>"/>
				</a>
			</div>

			<div class="span9">
				<div>
					<h2 class="fpp_title">
						<?php echo $this->program->Name; ?>

						<?php
						for ($i = 0; $i < 4; $i++) {
							if ($i < $this->program->Sterne)
								echo MsHtml::icon(MsHtml::ICON_STAR);
							else
								echo MsHtml::icon(MsHtml::ICON_STAR_EMPTY);
						}
						?>
					</h2>



				</div>

				<p class="fpp_description">
					<?php echo $this->program->Description; ?>
				</p>

				<p>
					<?php
					if (!empty($this->program->Kategorie)) {
						echo MsHtml::icon(MsHtml::ICON_TAG);
						echo $this->program->Kategorie . '';
					}
					?>
				</p>

				<p>
					<?php
					foreach ($this->program->getLanguageList() as $lang) {
						echo MsHtml::icon(MsHtml::ICON_GLOBE);
						echo $lang;
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					?>
				</p>
			</div>
		</div>
	</div>

	<br />
	<div class="fpp_footer">
		<p>
			<a class="btn btn-primary btn-large" href="<?php echo $this->program->getLink(); ?>">
				Show &raquo;
			</a>
		</p>
	</div>
</div>