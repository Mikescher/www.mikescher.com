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

	<h1>My Programs</h1>
	<br><br>

	<div class="row-fluid">

		<?php
		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "visible=1";

		$all = Program::model()->findAll($criteria);
		$rows = ceil((count($all) / 4));

		for ($i = 0; $i < $rows; $i++) {
			echo '<ul class="thumbnails">';

			foreach (array_slice($all, $i * 4, 4) as $record) {
				$this->widget('ThumbnailPreview',
					[
						'caption' => $record->attributes['Thumbnailname'],
						'link' => '/programs/view/' . $record->attributes['Name'],
						'description' => $record->attributes['Description'],
						'category' => $record->attributes['Kategorie'],
						'language' => explode("|", $record->attributes['Language']),
						'image' => '/images/programs/thumbnails/' . $record->attributes['Name'] . '.jpg',
						'starcount' => $record->attributes['Sterne'],
						'downloads' => $record->attributes['Downloads'],
						'date' => new DateTime($record->attributes['add_date']),
					]);
			}

			echo '</ul>';
		}
		?>

	</div>
</div>

