<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Programs
{
	public static function readSingle($a)
	{
		$a['thumbnail_url']        = '/data/images/program_thumbnails/' . $a['internal_name'] . '.png';
		$a['file_longdescription'] = (__DIR__ . '/../statics/programs/' . $a['internal_name'] . '_description.md');
		$a['url']                  = '/programs/view/' . $a['internal_name'];

		return $a;
	}

	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/programs/__all.php');

		return array_map('self::readSingle', $all);
	}

	public static function listAllNewestFirst($filter = '')
	{
		$data = self::listAll();
		usort($data, function($a, $b) { return strcasecmp($b['add_date'], $a['add_date']); });
		if ($filter !== '') $data = array_filter($data, function($a) use($filter) { return strtolower($a['category']) === strtolower($filter); });
		return $data;
	}

	public static function listUpdateData()
	{
		$a = require (__DIR__ . '/../statics/updates/programupdates.php');
		return $a;
	}

	public static function getProgramByInternalName($id)
	{
		foreach (self::listAll() as $prog) {
			if (strcasecmp($prog['internal_name'], $id) === 0) return $prog;
			if ($prog['internal_name_alt'] !== null && strcasecmp($prog['internal_name_alt'], $id) === 0) return $prog;
		}
		return null;
	}

	public static function getProgramDescription($prog)
	{
		return file_get_contents($prog['file_longdescription']);
	}
}