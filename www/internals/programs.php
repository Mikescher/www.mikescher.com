<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Programs
{
	const URL_ORDER =
	[
		'github',
		'sourceforge',

		'download',
		'playstore',
		'amazonappstore',
		'windowsstore',
		'itunesstore',

		'homepage',
		'wiki',
		'alternativeto',
	];

	const LICENSES =
	[
		'MIT'         => 'https://choosealicense.com/licenses/mit/',
		'Unlicense'   => 'https://choosealicense.com/licenses/unlicense/',
		'GPL-3.0'     => 'https://choosealicense.com/licenses/gpl-3.0/',
		'Apache-2.0'  => 'https://choosealicense.com/licenses/apache-2.0/',
		'Mozilla-2.0' => 'https://choosealicense.com/licenses/mpl-2.0/',
	];

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

	public static function urlComparator($a, $b)
	{
		$ia = array_search($a, Programs::URL_ORDER);
		$ib = array_search($b, Programs::URL_ORDER);

		if ($ia === false && $ib === false) return strcasecmp($a, $b);
		if ($ia === false && $ib !== false) return +1; // sort [IA | IB]
		if ($ia !== false && $ib === false) return -1; // sort [IB | IA]

		return ($ia < $ib) ? -1 : +1;

	}

	public static function sortUrls($urls)
	{
		uksort($urls, 'self::urlComparator');
		return $urls;
	}

	public static function getLicenseUrl($license)
	{
		return self::LICENSES[$license];
	}
}