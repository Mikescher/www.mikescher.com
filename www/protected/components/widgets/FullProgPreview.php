<?php

class FullProgPreview extends CWidget {
	/**
	 * @var $program Program
	 */
	public $program;

	public $caption = ' ?? caption ?? ';

	public function run() {
		$this->render('fullProgPreview');
	}
}