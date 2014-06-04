<?php
/* @var $this SiteController */
/* @var $program Program */

$this->pageTitle=Yii::app()->name;

$this->breadcrumbs=
	[
		'Index'
	];

$this->selectedNav = 'index';

?>

<div class="container">

	<!-- Main hero unit for a primary marketing message or call to action -->

	<?php
	$this->widget('FullProgPreview',
		[
			'caption' => "Program of the Day:",
			'program' => $program,
		]);
	?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World", "/log/1"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<?php echo MsHtml::collapsedHeader(new DateTime(), "Hello World"); ?>

	<!-- Example row of columns -->
	<div class="row">
		<div class="span4">
			<h2>Heading YD: <?php echo YII_DEBUG ?></h2>

			<p>

				<?php
				$connection = Yii::app()->db;

				$command=$connection->createCommand("SELECT * FROM {{Programs}}");
				$command->execute();   // a non-query SQL statement execution
				// or execute an SQL query and fetch the result set
				$reader=$command->query();

				// each $row is an array representing a row of data
				$dbgtxt = "";
				foreach($reader as $row)
				{
					$dbgtxt = $dbgtxt . print_r($row, true);
				}

				echo TbHtml::textArea('dbgtxt', $dbgtxt, array('rows' => 5));
				?>

			</p>

			<p><a class="btn" href="#">View details &raquo;</a></p>
		</div>
		<div class="span4">
			<h2>Heading</h2>

			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
				condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
				euismod. Donec sed odio dui. </p>

			<p><a class="btn" href="#">View details &raquo;</a></p>
		</div>
		<div class="span4">
			<h2>Heading</h2>

			<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula
				porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
				fermentum massa justo sit amet risus.</p>

			<p><a class="btn" href="#">View details &raquo;</a></p>
		</div>
	</div>
</div>