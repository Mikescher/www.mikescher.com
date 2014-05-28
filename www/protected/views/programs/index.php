<?php
/* @var $this ProgramController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
	'Programs',
);

$this->menu = array(
	array('label' => 'Create Program', 'url' => array('create')),
	array('label' => 'Manage Program', 'url' => array('admin')),
);
?>

<div class="container">
	<div class="span12">
		<h1>My Prog's</h1>
		<br>
		<br>
		<?php

		foreach (Program::model()->findAll() as $record) {
			echo "<div class='well'>";
			echo nl2br(print_r($record->attributes, true));
			echo "</div>";
		}


		?>
	</div>
</div>

