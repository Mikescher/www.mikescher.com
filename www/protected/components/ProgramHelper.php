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
	 * @param DateTime $date
	 * @return Program
	 */
	public static function GetRecentProg($date)
	{
		$criteria = new CDbCriteria;
		$criteria->order = "add_date DESC";
		$criteria->condition = "DATEDIFF('" . $date->format('Y-m-d') . "', add_date) <= 14 AND visible=1 AND enabled=1";
		$criteria->limit = 1;

		return Program::model()->find($criteria);
	}

	/**
	 * @param string $date
	 * @return Program
	 */
	public static function GetDailyProg($date = 'now')
	{
		if ($date == 'now') {
			$date = new DateTime();
		}

		$recent = self::GetRecentProg($date);

		if ($recent != null)
			return $recent;

		$toparray = self::GetHighlightedProgList(false);

		$msrand = new SeededRandom();
		$msrand->seedWithDailySeed($date);

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
				$progDropDown[] = MsHtml::menuDivider();
			else
				$progDropDown[] = array('label' => $row->Name, 'url' => $row->getLink());
		}
		return $progDropDown;
	}

	public static function convertDescriptionListToTabs($descriptions, $name) {
		$tabs = array();

		foreach($descriptions as $desc)
		{
			if ($desc['type'] === 0)
			{
				$tabs[] =
					[
						'label' => $desc['name'],
						'items' => self::convertDescriptionListToTabs($desc['items'], $name),
					];
			}
			else if (strcasecmp($desc['name'], 'index') == 0) // == 0 : true
			{
				$tabs[] =
					[
						'label' => $name,
						'content' => self::getDescriptionMarkdownTab($desc['path']),
						'active' => true,
					];
			}
			else
			{
				$tabs[] =
					[
						'label' => $desc['name'],
						'content' => self::getDescriptionMarkdownTab($desc['path']),
					];
			}
		}

		return $tabs;
	}

	public static function getDescriptionMarkdownTab($path)
	{
		$content = file_get_contents($path);

		$result = '<div class="markdownOwner"><div><p>';
		$result .=  ParsedownHelper::parse($content);
		$result .= '</p></div></div>';

		return $result;
	}

	/**
	 * @param $filename
	 * @param $number
	 * @return string
	 */
	public static function getIndexedFilename($filename, &$number)
	{
		$bn = basename($filename, '.markdown');

		if ($bn[0] >= '0' && $bn[0] <= '9' && $bn[1] >= '0' && $bn[1] <= '9' && $bn[2] == '_')
		{
			$name = substr($bn, 3);
			$number = substr($bn, 0, 2) + 0;
		}
		else
		{
			$name = $bn;
			$number = -1;
		}

		return $name;
	}
} 