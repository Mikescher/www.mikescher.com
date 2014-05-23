<?php
/* @var $this ProgrammeController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs = array(
	'Programme',
);

$this->menu = array(
	array('label' => 'Create Programme', 'url' => array('create')),
	array('label' => 'Manage Programme', 'url' => array('admin')),
);
?>

<div class="container">
	<div class="span12">
		<h1>My Prog's</h1>
		<br>
		<br>
		<?php

		foreach (Programme::model()->findAll() as $record) {
			echo "<div class='well'>";
			echo nl2br(print_r($record->attributes, true));
			echo "</div>";
		}


		?>
	</div>
</div>

