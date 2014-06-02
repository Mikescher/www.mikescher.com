<?php
/* @var $this ProgramController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php

	const PROGS_INDEX_ROWSIZE = 4;
	const PROGS_INDEX_PAGESIZE = 16;

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

		$pagecount = ceil(count($all) / PROGS_INDEX_PAGESIZE);

		$all = array_slice($all, ($page - 1) * PROGS_INDEX_PAGESIZE, PROGS_INDEX_PAGESIZE);

		$rowcount = ceil((count($all) / PROGS_INDEX_ROWSIZE));

		for ($i = 0; $i < $rowcount; $i++) {
			echo '<ul class="thumbnails">';

			foreach (array_slice($all, $i * PROGS_INDEX_ROWSIZE, PROGS_INDEX_ROWSIZE) as $record) {
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
						'enabled' => $record->attributes['enabled'],
					]);
			}

			echo '</ul>';
		}
		?>

	</div>

	<?php

	if ($pagecount > 1) {
		$pagination_arr = array();

		$pagination_arr[] = ['label' => '&laquo;', 'url' => '?page=' . ($page-1), 'disabled' => ($page <= 1)];
		for($i = 1; $i <= $pagecount; $i++) {
			$pagination_arr[] = ['label' => $i, 'url' => '?page=' . $i, 'active' => ($i == $page)];
		}
		$pagination_arr[] = ['label' => '&raquo;', 'url' => '?page=' . ($page+1), 'disabled' => ($page >= $pagecount)];

		echo TbHtml::pagination($pagination_arr,
			[
				'align' => 'right',
			]);
	}
	?>

</div>

