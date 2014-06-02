<?php

class ThumbnailPreview extends CWidget {
	public $caption = '';
	public $link = '';
	public $enabled = true;
	public $description = '';
	public $category = '';
	public $language = [];
	public $starcount = 0;
	public $downloads = 0;
	public $date = null;
	public $image = '';

	public function run() {
		if ($this->date == null)
			$this->date = new DateTime('2000-01-01');
		$this->render('thumbnailPreview');
	}
}

?>