<?php

class MsHelper {
	public static function getStringDBVar($name)
	{
		$connection = Yii::app()->db;

		$command=$connection->createCommand("SELECT SValue FROM {{othervalues}} WHERE Name = '$name'");
		$val = $command->queryScalar();

		return $val;
	}

	public static function getIntDBVar($name)
	{
		$connection = Yii::app()->db;

		$command=$connection->createCommand("SELECT [Value] FROM {{othervalues}} WHERE Name = '$name'");
		$val = $command->queryScalar();

		return $val;
	}

	public static function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	public static function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}

	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	public static function formatMilliseconds($millis)
	{
		if ($millis < 1000)
		{
			return $millis . 'ms';
		}
		else if ($millis < 10 * 1000)
		{
			return number_format($millis / (1000), 2) . 's';
		}
		else if ($millis < 60 * 1000)
		{
			return floor($millis / (1000)) . 's';
		}
		else if ($millis < 10 * 60 * 1000)
		{
			return floor($millis / (60 * 1000)) . 'min ' . floor(($millis % (60 * 1000)) / 1000) . 's';
		}
		else if ($millis < 60 * 60 * 1000)
		{
			return floor($millis / (60 * 1000)) . 'min';
		}
		else if ($millis < 10 * 60 * 60 * 1000)
		{
			return number_format($millis / (60 * 60 * 1000), 2) . ' hours';
		}
		else
		{
			return floor($millis / (60 * 60 * 1000)) . ' hours';
		}
	}

	/**
	 * Appends/Prepends $before/$after to every line in $input
	 *
	 * @param $input
	 * @param $before
	 * @param $after
	 * @return mixed
	 */
	public function encloseLines($input, $before, $after)
	{
		$array = preg_split("/\r\n|\n|\r/", $input);

		for($i = 0; $i < count($array); $i++)
			$array[$i] = $before . $array[$i] . $after;

		return implode(PHP_EOL, $array);
	}
} 