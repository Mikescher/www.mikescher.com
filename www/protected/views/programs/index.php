<?php
/* @var $this ProgramsController */
/* @var $page integer  */
/* @var $pagecount integer */
/* @var $rowcount integer */
/* @var $data Program[][] */
?>

<?php

$this->pageTitle = 'Programs - ' . Yii::app()->name;

$this->breadcrumbs = array(
		'Programs',
	);
?>

<div class="container">

	<?php echo MsHtml::pageHeader("Programs", "Games and Tools, developed by me"); ?>

	<div class="row-fluid">
		<?php

		foreach($data as $datarow) {
			echo '<ul class="thumbnails">';

			foreach($datarow as $dataelem) {
				/* @var $dataelem Program */
				$this->widget('ThumbnailProgPreview',
					[
						'caption' => $dataelem->Thumbnailname,
						'link' => $dataelem->getLink(),
						'description' => $dataelem->Description,
						'category' => $dataelem->Kategorie,
						'language' => $dataelem->getLanguageList(),
						'image' => $dataelem->getImagePath(),
						'starcount' => $dataelem->Sterne,
						'downloads' => $dataelem->Downloads,
						'date' => $dataelem->getDateTime(),
						'enabled' => $dataelem->enabled,
						'programminglang' => $dataelem->programming_lang,
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

		echo MsHtml::pagination($pagination_arr,
			[
				'align' => 'right',
			]);
	}
	?>

</div>

