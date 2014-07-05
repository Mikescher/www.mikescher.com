<?php
/* @var $this ProgramsController */
/* @var $model Program */
?>

<?php

$this->pageTitle = $model->Name . ' - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'Programs' => array('index'),
	$model->Name,
);
?>

<?php
if (!$model->visible && Yii::app()->user->name != 'admin') {
	throw new CHttpException(400, "You cannot view this program");
}
?>

<div class="container">
	<?php if (!$model->enabled) echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, TbHtml::b('Warning!') . '     	This programm is for normal users disabled'); ?>
	<?php if (!$model->visible) echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, TbHtml::b('Warning!') . '     	This programm is for normal users invisible'); ?>

	<div class="row">
		<div class="span3">
			<div class="well progview_infocol">
				<h2 class="text-center">Info</h2>


				<div class="progview_infocontent">
					<table>
						<tr>
							<td>Stars:</td>
							<td><?php echo $model->getStarHTML(); ?></td>
						</tr>
						<tr>
							<td>Downloads:</td>
							<td><?php echo TbHtml::badge($model->Downloads, array('color' => TbHtml::BADGE_COLOR_SUCCESS)); ?></td>
						</tr>
						<tr>
							<td>Languages:</td>
							<td><?php foreach ($model->getLanguageList() as $lang) echo TbHtml::badge($lang, array('color' => TbHtml::BADGE_COLOR_INFO)); ?></td>
						</tr>
						<tr>
							<td>Added:</td>
							<td><?php echo TbHtml::badge($model->getDateTime()->format('d.m.Y'), array('color' => TbHtml::BADGE_COLOR_INFO)); ?></td>
						</tr>
						<?php if ($model->version != null): ?>
							<tr>
								<td>Version:</td>
								<td><?php echo TbHtml::badge($model->version->Version, array('color' => TbHtml::BADGE_COLOR_INFO)); ?></td>
							</tr>
						<?php endif ?>
						<?php
						// TODO-MS Add Highscore Tables to MVC
						// TODO-MS Show highest score when highscore_gid is set
						?>
					</table>
				</div>

				<div class="text-right progview_inforow">
					<?php if ($model->uses_absCanv): ?>
						<a href="/programs/view/AbsCanvas">
							<?php echo TbHtml::badge('AbsCanvas', array('color' => TbHtml::BADGE_COLOR_WARNING)); ?>
						</a>
					<?php endif ?>

					<?php echo TbHtml::badge($model->programming_lang, array('color' => TbHtml::BADGE_COLOR_WARNING)); ?>
				</div>
			</div>
		</div>

		<div class="span6">
			<?php
				$this->widget('ProgDescription',
					[
						'program' => $model,
					]
				);
			?>
		</div>

		<div class="span3">
			<div class="well">
				<img src="<?php echo $model->getImagePath(); ?>" class="progview_image"/>

				<div class="progview_donwloadbtns">
					<?php
					echo TbHtml::linkbutton('Download',
						[
							'block' => true,
							'color' => TbHtml::BUTTON_COLOR_PRIMARY,
							'size' => TbHtml::BUTTON_SIZE_DEFAULT,
							'url' => '#', //TODO-MS Add Download link
						]);
					?>

					<?php
					if (!empty($model->github_url))
						echo TbHtml::linkbutton('Github',
							[
								'block' => true,
								'color' => TbHtml::BUTTON_COLOR_INFO,
								'size' => TbHtml::BUTTON_SIZE_DEFAULT,
								'url' => $model->github_url,
							]);
					?>

					<?php
					if (!empty($model->sourceforge_url))
						echo TbHtml::linkbutton('Sourceforge',
							[
								'block' => true,
								'color' => TbHtml::BUTTON_COLOR_INFO,
								'size' => TbHtml::BUTTON_SIZE_DEFAULT,
								'url' => $model->sourceforge_url,
							]);
					?>

					<?php
					if (!empty($model->homepage_url))
						echo TbHtml::linkbutton('Homepage',
							[
								'block' => true,
								'color' => TbHtml::BUTTON_COLOR_INFO,
								'size' => TbHtml::BUTTON_SIZE_DEFAULT,
								'url' => $model->homepage_url,
							]);
					?>

					<?php
					if ($model->highscore_gid >= 0)
						echo TbHtml::linkbutton('Highscore',
							[
								'block' => true,
								'color' => TbHtml::BUTTON_COLOR_SUCCESS,
								'size' => TbHtml::BUTTON_SIZE_DEFAULT,
								'url' => '#', //TODO-MS Add Highscore link
							]);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
