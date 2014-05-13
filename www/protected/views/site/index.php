<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->breadcrumbs=
	[
		'Index'
	];
?>

<div class="container">

	<!-- Main hero unit for a primary marketing message or call to action -->
	<div class="hero-unit">
		<h1>Hello, world!</h1>

		<p> 
		
		<ul>
			<li>View file: <code><?php echo __FILE__; ?></code></li>
			<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
		</ul>
		
		</p>

		<p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
	</div>

	<!-- Example row of columns -->
	<div class="row">
		<div class="span4">
			<h2>Heading YD: <?php echo YII_DEBUG ?></h2>

			<p>
			
			<?php
				$connection = Yii::app()->db;
				
				$command=$connection->createCommand("SELECT * FROM programme");
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

	<hr>

	<footer>
		<p>&copy; Company 2012</p>
	</footer>
</div>