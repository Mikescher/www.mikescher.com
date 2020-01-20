<?php

class WebApps implements IWebsiteModule
{
	/** @var array */
	private $staticData;

	public function __construct()
	{
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/webapps/__all.php');

		$this->staticData = array_map(function($a){return self::readSingle($a);}, $all);
	}

	private static function readSingle($a)
	{
		return $a;
	}

	public function listAllNewestFirst()
	{
		$data = $this->staticData;
		usort($data, function($a, $b) { return strcasecmp($b['date'], $a['date']); });
		return $data;
	}

	public function checkConsistency()
	{
		$warn = null;

		$this->load();

		$ids = [];

		foreach ($this->staticData as $prog)
		{
			if (in_array($prog['id'], $ids)) return ['result'=>'err', 'message' => 'Duplicate id ' . $prog['id']];
			$ids []= $prog['id'];
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}
}