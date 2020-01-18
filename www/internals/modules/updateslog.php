<?php

class UpdatesLog
{
	/** @var Website */
	private $site;

	/** @var array */
	private $staticData;

	public function __construct(Website $site)
	{
		$this->site = $site;
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/updates/__all.php');

		$this->staticData = array_map(function($a){return self::readSingle($a);}, $all);
	}

	private static function readSingle($d)
	{
		return $d;
	}

	public function listUpdateData()
	{
		return $this->staticData;
	}

	public function insert($name, $version)
	{
		$ip = get_client_ip();

		$ippath = (__DIR__ . '/../../dynamic/self_ip_address.auto.cfg');
		$self_ip = file_exists($ippath) ? file_get_contents($ippath) : 'N/A';

		if ($self_ip === $ip) $ip = "self";

		$this->site->modules->Database()->sql_exec_prep("INSERT INTO updateslog (programname, ip, version, date) VALUES (:pn, :ip, :vn, NOW())",
			[
				[':pn', $name,    PDO::PARAM_STR],
				[':ip', $ip,      PDO::PARAM_STR],
				[':vn', $version, PDO::PARAM_STR],
			]);
	}

	public function listProgramsInformation()
	{
		return $this->site->modules->Database()->sql_query_assoc('SELECT programname AS name, Count(*) as count_total, MAX(date) AS last_query, (SELECT COUNT(*) FROM updateslog AS u1 WHERE u1.programname=u0.programname AND NOW() - INTERVAL 7 DAY < u1.date) AS count_week FROM updateslog AS u0 GROUP BY programname');
	}

	public function getEntries($name, $limit)
	{
		return $this->site->modules->Database()->sql_query_assoc_prep('SELECT * FROM updateslog WHERE programname = :pn ORDER BY date DESC LIMIT :lt',
			[
				[':pn', $name,    PDO::PARAM_STR],
				[':lt', $limit,   PDO::PARAM_INT],
			]);
	}
}