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
} 