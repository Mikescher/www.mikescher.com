<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Programs
{
	public static function readSingle($f)
	{
		$a = require $f;
		return $a;
	}

	public static function listAll()
	{
		$files = glob(__DIR__ . '/../statics/programs/*.php');
		
		return array_map(readSingle, $files);
	}

	public static function listUpdateData()
	{
		$a = require (__DIR__ . '/../statics/updates/programupdates.php');
		return $a;
	}
}