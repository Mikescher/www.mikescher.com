<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Euler
{
	public static function readSingle($f)
	{
		$a = require $f;
		$a['rating'] = self::rateTime($a);
		return $a;
	}

	public static function listAll()
	{
		$files = glob(__DIR__ . '/../statics/euler/euler_*.php');
		
		return array_map('self::readSingle', $files);
	}

	public static function rateTime($problem)
	{
		if ($problem['time'] < 100) // < 100ms
			return 0;

		if ($problem['time'] < 15 * 1000) // < 5s
			return 1;

		if ($problem['time'] < 60 * 1000) // < 1min
			return 2;

		if ($problem['time'] < 5 * 60 * 1000) // < 5min
			return 3;

		return 4;
	}
}

