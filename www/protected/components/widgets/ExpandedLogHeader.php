<?php

class ExpandedLogHeader extends CWidget {
	public $date;
	public $caption = '';
	public $link = '';
	public $content = '';

	public $collapseID = -1;
	public $collapseOwner = '';
	public $collapseOpen = false;

	public function run() {
		if ($this->date == null)
			$this->date = new DateTime('2000-01-01');

		$this->render('expandedLogHeader');
	}

	/**
	 * @return bool
	 */
	public function isCollapsable() {
		return ($this->collapseID >= 0);
	}

	public function getContentID() {
		return 'expCollapseElem' . $this->collapseID;
	}

	public function getContentTagDefinition() {
		$contentClasses = 'expCollContent markdownOwner';
		$contentID = '';

		if ($this->isCollapsable()) {
			$contentClasses .= ' collapse';
			if ($this->collapseOpen) {
				$contentClasses .= ' in';
			}

			$contentID = 'id="' . $this->getContentID() . '"';
		}

		$contentClasses = 'class="' . $contentClasses . '"';

		return ' ' . $contentClasses . ' ' . $contentID;
	}
}