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
	<div class="row-fluid">

		<?php
		$all = Program::model()->findAll();
		$rows = ceil((count($all) / 4));

		for ($i = 0; $i < $rows; $i++) {
			echo '<ul class="thumbnails">';

			foreach (array_slice(Program::model()->findAll(), $i * 4, 4) as $record) {
				$this->widget('ThumbnailPreview',
					[
						'caption' => $record->attributes['Thumbnailname'],
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

