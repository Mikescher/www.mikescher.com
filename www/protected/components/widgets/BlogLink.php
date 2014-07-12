<?php

class BlogLink extends CWidget {
	public $date;
	public $caption = '';
	public $link = '';

	public function run() {
		if ($this->date == null)
			$this->date = new DateTime('2000-01-01');

		$this->render('blogLink');
	}
}