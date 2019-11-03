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
		'cs'   => ['ext'=>'linq', 'css'=>'language-csharp',        'name'=>'C#'],
		'java' => ['ext'=>'java', 'css'=>'language-java',          'name'=>'Java'],
		'bef'  => ['ext'=>'b93',  'css'=>'language-befungerunner', 'name'=>'Befunge-93+'],
		'cpp'  => ['ext'=>'cpp',  'css'=>'language-cpp',           'name'=>'C++'],
		'pyth' => ['ext'=>'py',   'css'=>'language-python',        'name'=>'Python'],
		'rust' => ['ext'=>'rs',   'css'=>'language-rust',          'name'=>'Rust'],
		'go'   => ['ext'=>'go',   'css'=>'language-go',            'name'=>'Go'],
		'js'   => ['ext'=>'js',   'css'=>'language-javascript',    'name'=>'Javascript'],
		'pas'  => ['ext'=>'pas',  'css'=>'language-pascal',        'name'=>'Pascal/Delphi'],
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

		$result = $all[$year];

		array_walk($result, function(&$value) use ($year) { $value = self::readSingle($year, $value); });

		return $result;
	}

	public static function listSingleYearAssociative($year)
	{
		$all = self::listSingleYear($year);

		$result = array_fill(0, 25, null);

		foreach ($all as $d)
		{
			$result[$d['day']-1] = $d;
		}

		return $result;
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

		$a['date']     = $year . '-' . 12 . '-' . $n2p;

		$solutionfiles = [];

		for ($i=1; $i <= $a['parts']; $i++)
		{
			$solutionfiles []= (__DIR__ . '/../statics/aoc/' . $year . '/' . $n2p . '-' . $i . '.' . self::LANGUAGES[$a['language']]['ext']);
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

	public static function getGithubLink($year)
	{
		return self::YEARS['' . $year]['github'];
	}

	public static function getURLForYear($year)
	{
		return '/blog/' . self::YEARS[''.$year]['blog-id'] . '/Advent_of_Code_' . $year . '/';
	}

	public static function getPrevYear($year)
	{
		$last = null;
		foreach (self::YEARS as $y => $d)
		{
			if ($y == $year) return $last;
			$last = $y;
		}
		return null;
	}

	public static function getNextYear($year)
	{
		$found = false;
		foreach (self::YEARS as $y => $d)
		{
			if ($found) return $y;
			if ($y == $year) $found = true;
		}
		return null;
	}

	public static function getLanguageCSS($data)
	{
		return self::LANGUAGES[$data['language']]['css'];
	}

	public static function getSolutionCode($data, $i)
	{
		$raw = file_get_contents($data['file_solutions'][$i]);

		if ($data['language'] === 'cs')
		{
			$raw = trim($raw);
			if (startsWith($raw, '<Query Kind="Program" />'))    $raw = substr($raw, strlen('<Query Kind="Program" />'));
			if (startsWith($raw, '<Query Kind="Expression" />')) $raw = substr($raw, strlen('<Query Kind="Expression" />'));
			if (startsWith($raw, '<Query Kind="Statements" />')) $raw = substr($raw, strlen('<Query Kind="Statements" />'));
			$raw = trim($raw);
		}

		return $raw;
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

				if ($aocdata['day'] < 1 || $aocdata['day'] > 25) return ['result'=>'err', 'message' => 'Invali [day]-value title ' . $aocdata['day']];

				if (count($aocdata['solutions']) !== $aocdata['parts'])      return ['result'=>'err', 'message' => 'Not enough solution-values in day' . $aocdata['day']];
				if (count($aocdata['file_solutions']) !== $aocdata['parts']) return ['result'=>'err', 'message' => 'Not enough solution-files in day' . $aocdata['day']];

				if (!file_exists($aocdata['file_challenge'])) return ['result'=>'err', 'message' => 'file_challenge not found ' . $aocdata['file_challenge']];
				if (!file_exists($aocdata['file_input']))     return ['result'=>'err', 'message' => 'file_input not found ' .     $aocdata['file_input']];

				foreach ($aocdata['file_solutions'] as $sfile)
				{
					if (!file_exists($sfile)) return ['result'=>'err', 'message' => 'file_solution[?] not found ' . $sfile];
				}

				if (!array_key_exists($aocdata['language'], self::LANGUAGES)) return ['result'=>'err', 'message' => 'Unknown language ' . $aocdata['language']];
			}
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}
}