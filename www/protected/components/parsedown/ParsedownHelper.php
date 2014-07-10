<?php

/**
 * Class ParsedownHelper
 */
class ParsedownHelper {
	/**
	 * @param string $raw_text
	 * @return string
	 */
	public static function parse($raw_text)
	{
		$Instance = new ParsedownExtra();

		return $Instance->text($raw_text);
	}
}