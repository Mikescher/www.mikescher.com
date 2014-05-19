<?php /* @var $this Controller */

require_once('protected/lib/ArrayX.php');
use Yiinitializr\Helpers\ArrayX;

?>
<?php $this->beginContent('//layouts/main'); ?>
	<div class="container">
		<div class="row">
			<div class="span-9" style="width: 870px;">
				<div id="content">
					<?php echo $content; ?>
				</div>
				<!-- content -->
			</div>
			<div class="span-3">
				<div class="well" style="max-width: 340px; padding: 8px 0;">
					<?php
					$this->widget('bootstrap.widgets.TbNav',
						[
							'type' => TbHtml::NAV_TYPE_LIST,
							'items' => ArrayX::merge(
									[
										['label' => 'List header'],
									],
									$this->menu)
						]
					);
					?>
				</div>
				<!-- well -->
			</div>
		</div>
	</div>
<?php $this->endContent(); ?>