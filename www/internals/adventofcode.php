<?php

class AdventOfCode
{
	const YEARS =
	[
		'2018' => [ 'url-aoc'=>'https://adventofcode.com/2018/day/', 'blog-id' => 23, 'github' => 'https://github.com/Mikescher/AdventOfCode2018' ],
		'2019' => [ 'url-aoc'=>'https://adventofcode.com/2019/day/', 'blog-id' => 24, 'github' => 'https://github.com/Mikescher/AdventOfCode2019' ],
	];

	const LANGUAGES =
	[
		'cs' => ['ext'=>'linq', 'css'=>'language-csharp', 'name'=>'C#'],
	];

	public static function listAllFromAllYears()
	{
		$all = require (__DIR__ . '/../statics/aoc/__all.php');

		array_walk($all, function(&$value, $year) { array_walk($value, function (&$innervalue) use ($year) { $innervalue = self::readSingle($year, $innervalue); }); });

		return $all;
	}

	public static function listSingleYear($year)
	{
		$all = require (__DIR__ . '/../statics/aoc/__all.php');

		return array_map('self::readSingle', $all[$year]);
	}

	public static function listYears()
	{
		$all = require (__DIR__ . '/../statics/aoc/__all.php');

		return array_keys($all);
	}

	public static function readSingle($year, $a)
	{
		$yeardata = self::YEARS[$year];

		$n2p = str_pad($a['day'], 2, '0', STR_PAD_LEFT);
		$a['day-padded'] = $n2p;

		$a['url']       = '/blog/' . $yeardata['blog-id'] . '/Advent_of_Code_' . $year . '/day-' . $n2p;
		$a['canonical'] = "https://www.mikescher.com" . $a['url'];

		$a['url_aoc']    = $yeardata['url-aoc'] . $a['day']; // adventofcode.com/{year}/day/{day}

		$a['file_challenge'] = (__DIR__ . '/../statics/aoc/'.$year.'/'.$n2p.'_challenge.txt');
		$a['file_input']     = (__DIR__ . '/../statics/aoc/'.$year.'/'.$n2p.'_input.txt');

		$solutionfiles = [];

		foreach ($a['languages'] as $language)
		{
			for ($i=1; $i <= $a['parts']; $i++)
			{
				$solutionfiles []= (__DIR__ . '/../statics/aoc/' . $year . '/' . $n2p . '-' . $i . '.' . self::LANGUAGES[$language]['ext']);
			}
		}

		$a['file_solutions'] = $solutionfiles;

		return $a;
	}

	public static function getDayFromStrIdent($year, $ident)
	{
		$e = explode('-', $ident, 2); // day-xxx
		if (count($e)!==2) return null;

		$i = intval($e[1], 10);
		if ($i == 0) return null;

		return self::getSingleDay($year, $i);
	}

	public static function getSingleDay($year, $day)
	{
		foreach (self::listSingleYear($year) as $aocd) {
			if ($aocd['day'] == $day) return $aocd;
		}
		return null;
	}

	public static function checkConsistency()
	{
		$warn = null;

		foreach (self::listAllFromAllYears() as $year => $yd)
		{
			$daylist = [];
			$titlelist = [];

			if (!array_key_exists($year, self::YEARS)) return ['result'=>'err', 'message' => 'Invalid Year: ' . $year];

			foreach ($yd as $aocdata)
			{
				if (in_array($aocdata['day'], $daylist)) return ['result'=>'err', 'message' => 'Duplicate day ' . $aocdata['day']];
				$daylist []= $aocdata['day'];

				if (in_array($aocdata['title'], $titlelist)) return ['result'=>'err', 'message' => 'Duplicate title ' . $aocdata['title']];
				$titlelist []= $aocdata['title'];

				if (count($aocdata['solutions']) !== $aocdata['parts'])      return ['result'=>'err', 'message' => 'Not enough solution-values in day' . $aocdata['day']];
				if (count($aocdata['file_solutions']) !== $aocdata['parts']) return ['result'=>'err', 'message' => 'Not enough solution-files in day' . $aocdata['day']];

				if (!file_exists($aocdata['file_challenge'])) return ['result'=>'err', 'message' => 'file_challenge not found ' . $aocdata['file_challenge']];
				if (!file_exists($aocdata['file_input']))     return ['result'=>'err', 'message' => 'file_input not found ' .     $aocdata['file_input']];

				foreach ($aocdata['file_solutions'] as $sfile)
				{
					if (!file_exists($sfile)) return ['result'=>'err', 'message' => 'file_solution[?] not found ' . $sfile];
				}

				foreach ($aocdata['languages'] as $lang)
				{
					if (!array_key_exists($lang, self::LANGUAGES)) return ['result'=>'err', 'message' => 'Unknown language ' . $lang];
				}
			}
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}
}