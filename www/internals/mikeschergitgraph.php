<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egg/ExtendedGitGraph2.php');

class MikescherGitGraph
{
	/**
	 * @return ExtendedGitGraph2
	 * @throws Exception
	 */
	public static function create()
	{
		global $CONFIG;

		return new ExtendedGitGraph2($CONFIG['extendedgitgraph']);
	}

	public static function getPathRenderedData()
	{
		return __DIR__ . '/../dynamic/egg/cache_fullrenderer.html';
	}

	/**
	 * @return string|null
	 * @throws Exception
	 */
	public static function get()
	{
		$d = self::create()->loadFromCache();
		if ($d === null) return "";
		return $d;
	}

	public static function checkConsistency()
	{
		$p = self::getPathRenderedData();

		if (!file_exists($p)) return ['result'=>'err', 'message' => 'Rendered data not found'];

		if (filemtime($p) < time()-(24*60*60)) return ['result'=>'warn', 'message' => 'Rendered data is older than 1 day'];

		return ['result'=>'ok', 'message' => ''];
	}
}