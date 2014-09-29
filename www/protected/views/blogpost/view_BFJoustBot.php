<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
?>

<?php

$this->pageTitle = 'Blogpost: ' . $model->Title . ' - ' . Yii::app()->name;

$this->breadcrumbs = array(
	'Blog' => array('/blog'),
	$model->Title,
);

array_push($this->js_files, '/javascript/blogpost_BFJoustBot_script.js');
array_push($this->css_files, '/css/blogpost_BFJoustBot_style.css');

?>

<div class="container">

	<?php echo MsHtml::pageHeader("Blog", "My personal programming blog"); ?>

	<div class="blogOwner well markdownOwner" id="markdownAjaxContent">
		<?php
			$code_own = file_get_contents('data/blog/BFJoustBot/MultiVAC.bfjoust');
			$code_opp = file_get_contents('data/blog/BFJoustBot/Patashu_lazy.bfjoust');

			$md = str_replace("{{CODE}}", $code_own, $model->Content);
			echo ParsedownHelper::parse($md);
		?>

		<div>
			<textarea class="source" id="source_1"><?php echo htmlspecialchars($code_own); ?></textarea>
			<textarea class="source" id="source_2"><?php echo htmlspecialchars($code_opp); ?></textarea>
		</div>

		<div id="commandpanel">
			<div>
				<div>
					<a href="#" id="a_expand">expand</a>
					|
					<a href="#" id="a_collapse">collapse</a>
					|
					<a href="#" id="a_run">run</a>
					(size:
					<input type="number" id="run_size" min="10" max="30" value="30" width="30">
					speed:
					<input type="number" id="run_speed" min="0" max="10000" value="10">
					)
					|
					<a href="#" id="a_stop">stop</a>
					|
					<a href="#" id="a_arena">arena</a>
				</div>
			</div>
		</div>

		<div>
			<textarea class="sink" id="sink_1"></textarea>
			<textarea class="sink" id="sink_2"></textarea>
		</div>

		<div>
			<canvas   class="bottomelem" id="board"></canvas>
			<textarea class="bottomelem" id="log" wrap="off"> </textarea>
		</div>


		<div class="blogFooter">
			<div class="blogFooterLeft">
				<?php echo $model->Title; ?>
			</div>
			<div class="blogFooterRight">
				<?php echo $model->getDateTime()->format('d.m.Y'); ?>
			</div>
		</div>
	</div>

	<div class="disqus_owner">
		<?php
		$this->widget(
			'ext.YiiDisqusWidget.YiiDisqusWidget',
			[
				'shortname' => 'mikescher-de',
				'identifier' => 'blog/view/' + $model->ID,
				'title' => $model->Title,
				'url' => $model->getAbsoluteLink(),
				'category_id' => '3253401', // = blog/view
			]
		);
		?>
	</div>

</div>
