<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Programs
{
	public static function readSingle($a)
	{
		$a['thumbnail_url']        = '/data/images/program_thumbnails/' . $a['internal_name'] . '.png';
		$a['file_longdescription'] = (__DIR__ . '/../statics/programs/' . $a['internal_name'] . '_descrition.md');
		$a['url']                  = '/programs/view/' . $a['internal_name'];


		return $a;
	}

	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/programs/__all.php');

		return array_map('self::readSingle', $all);
	}

	public static function listAllNewestFirst()
	{
		$data = self::listAll();
		usort($data, function($a, $b) { return strcasecmp($b['add_date'], $a['add_date']); });
		return $data;
	}

	public static function listUpdateData()
	{
		$a = require (__DIR__ . '/../statics/updates/programupdates.php');
		return $a;
	}
}