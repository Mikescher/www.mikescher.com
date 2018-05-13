<?php

class WebApps
{
	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/webapps/__all.php');

		return array_map('self::readSingle', $all);
	}

	public static function readSingle($a)
	{
		return $a;
	}

	public static function listAllNewestFirst()
	{
		$data = self::listAll();
		usort($data, function($a, $b) { return strcasecmp($b['date'], $a['date']); });
		return $data;
	}
}


