<?php

/**
 * Class ProgramHelper
 */
class ProgramHelper {

	/**
	 * @param bool $doDelimiter
	 * @return Program[]
	 */
	public static function GetHighlightedProgList($doDelimiter)
	{
		$dropDownModels = array();

		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "visible=1 AND enabled=1";
		$criteria->limit = 3;
		foreach (Program::model()->findAll($criteria) as $row) {
			$dropDownModels[] = $row;
		}

		if ($doDelimiter)
		{
			$dropDownModels[] = null;
		}

		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->limit = 8;
		$criteria->condition = "Sterne >= 4 AND visible=1 AND enabled=1";
		foreach (Program::model()->findAll($criteria) as $row) {
			$contains = false;
			foreach($dropDownModels as $modelElem)
				if ($modelElem != null && $modelElem->ID == $row->ID)
					$contains = true;
			if (! $contains)
				$dropDownModels[] = $row;
		}

		return $dropDownModels;
	}

	/**
	 * @return Program
	 */
	public static function GetRecentProg()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "DATEDIFF(CURDATE(), add_date) <= 14 AND visible=1 AND enabled=1";
		$criteria->limit = 1;

		return Program::model()->find($criteria);
	}

	/**
	 * @return Program
	 */
	public static function GetDailyProg()
	{
		$recent = self::GetRecentProg();

		if ($recent != null)
			return $recent;

		$toparray = self::GetHighlightedProgList(false);

		$msrand = new SeededRandom();
		$msrand->seedWithDailySeed();

		$result = $msrand->getRandomElement($toparray);

		return $result;
	}

	/**
	 * @return array
	 */
	public static function GetProgDropDownList()
	{
		$progDropDown = array();

		$dropDownModels = self::GetHighlightedProgList(true);

		foreach ($dropDownModels as $row) {
			if (is_null($row))
				$progDropDown[] = TbHtml::menuDivider();
			else
				$progDropDown[] = array('label' => $row->Name, 'url' => $row->getLink());
		}
		return $progDropDown;
	}

} 