<?php

class Euler
{
	public static function readSingle($a)
	{
		$n3p = str_pad($a['number'], 3, '0', STR_PAD_LEFT);
		$a['number3'] = $n3p;

		$a['rating'] = self::rateTime($a);

		$a['url']       = '/blog/1/Project_Euler_with_Befunge/problem-' . $n3p;
		$a['canonical'] = "https://www.mikescher.com" . $a['url'];

		$a['is93'] = ($a['width'] <= 80 AND $a['height'] <= 25);

		$a['url_euler']  = 'https://projecteuler.net/problem=' . $n3p;
		$a['url_raw']    = 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-' . $n3p . '.b93';
		$a['url_github'] =  'https://github.com/Mikescher/Project-Euler_Befunge';

		$a['file_description'] = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'_description.md');
		$a['file_code']        = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'.b93');
		$a['file_explanation'] = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'_explanation.md');

		return $a;
	}

	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/euler/__all.php');

		return array_map('self::readSingle', $all);
	}

	public static function getEulerProblemFromStrIdent($ident)
	{
		$e = explode('-', $ident, 2); // problem-xxx
		if (count($e)!==2) return null;

		$i = intval($e[1], 10);
		if ($i == 0) return null;

		return self::getEulerProblem($i);
	}

	public static function getEulerProblem($num)
	{
		foreach (self::listAll() as $ep) {
			if ($ep['number'] == $num) return $ep;
		}
		return null;
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

	public static function checkConsistency()
	{
		$warn = null;

		$numbers = [];
		$realname = [];

		foreach (self::listAll() as $ep)
		{
			if (in_array($ep['number'], $numbers)) return ['result'=>'err', 'message' => 'Duplicate number ' . $ep['number']];
			$numbers []= $ep['number'];

			if (in_array($ep['title'], $realname)) return ['result'=>'err', 'message' => 'Duplicate title ' . $ep['title']];
			$realname []= $ep['title'];

			if (!file_exists($ep['file_description'])) return ['result'=>'err', 'message' => 'file_description not found ' . $ep['file_description']];
			if (!file_exists($ep['file_code']))        return ['result'=>'err', 'message' => 'file_code not found ' .        $ep['file_code']];
			if (!file_exists($ep['file_explanation'])) return ['result'=>'err', 'message' => 'file_explanation not found ' . $ep['file_explanation']];
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}
}

