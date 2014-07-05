<?php

class ProgDescription extends CWidget {
	/**
	 * @var $program Program
	 */
	public $program;

	public function run() {
		$descriptions = $this->program->getDescriptions();

		if (count($descriptions) === 1)
		{
			$this->render('progDescription',
				[
					'name' => $this->program->Name,
					'descriptions' => $descriptions,
				]);
		}
		else
		{
			$this->render('progDescription_tabbed',
				[
					'name' => $this->program->Name,
					'descriptions' => $descriptions,
				]);
		}


	}
}