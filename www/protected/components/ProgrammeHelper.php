<?php

class ProgrammeHelper {

	public static function GetHighlightedProgList($doDelimiter)
	{
		$dropDownModels = array();

		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "visible=1 AND enabled=1";
		$criteria->limit = 3;
		foreach (Programme::model()->findAll($criteria) as $row) {
			$dropDownModels[] = $row;
		}

		if ($doDelimiter)
		{
			$dropDownModels[] = null;
		}

		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->limit = 8;
		$criteria->condition = "Sterne=4 AND visible=1 AND enabled=1";
		foreach (Programme::model()->findAll($criteria) as $row) {
			$dropDownModels[] = $row;
		}

		return $dropDownModels;
	}

	public static function GetRecentProg()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "DATEDIFF(CURDATE(), add_date) <= 14 AND visible=1 AND enabled=1";
		$criteria->limit = 1;

		return Programme::model()->find($criteria);
	}

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

	public static function GetProgDropDownList()
	{
		$progDropDown = array();

		$dropDownModels = self::GetHighlightedProgList(true);

		foreach ($dropDownModels as $row) {
			if (is_null($row))
				$progDropDown[] = TbHtml::menuDivider();
			else
				$progDropDown[] = array('label' => $row->attributes['Name'], 'url' => '/programme/' . $row->attributes['Name']);
		}
		return $progDropDown;
	}

} 