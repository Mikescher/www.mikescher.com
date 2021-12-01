<?php

class AdventOfCode implements IWebsiteModule
{
	const YEARS =
	[
		'2017' => [ 'url-aoc'=>'https://adventofcode.com/2017/day/', 'blog-id' => 25, 'github' => 'https://github.com/Mikescher/AdventOfCode2017', 'single_solution_file' => false ],
		'2018' => [ 'url-aoc'=>'https://adventofcode.com/2018/day/', 'blog-id' => 23, 'github' => 'https://github.com/Mikescher/AdventOfCode2018', 'single_solution_file' => false ],
		'2019' => [ 'url-aoc'=>'https://adventofcode.com/2019/day/', 'blog-id' => 24, 'github' => 'https://github.com/Mikescher/AdventOfCode2019', 'single_solution_file' => false ],
		'2020' => [ 'url-aoc'=>'https://adventofcode.com/2020/day/', 'blog-id' => 26, 'github' => 'https://github.com/Mikescher/AdventOfCode2020', 'single_solution_file' => true  ],
		'2021' => [ 'url-aoc'=>'https://adventofcode.com/2021/day/', 'blog-id' => 27, 'github' => 'https://github.com/Mikescher/AdventOfCode2021', 'single_solution_file' => true  ],
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
		'ts'   => ['ext'=>'ts',   'css'=>'language-typescript',    'name'=>'Typescript'],
	];

	/** @var array */
	private $staticData;

	public function __construct()
	{
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/aoc/__all.php');

		array_walk($all, function(&$value, $year) { array_walk($value, function (&$innervalue) use ($year) { $innervalue = self::readSingle($year, $innervalue); }); });

		$this->staticData = $all;
	}

	public function listAllFromAllYears()
	{
		return $this->staticData;
	}

	public function listAllDays()
	{
		$r = [];
		foreach ($this->staticData as $year => $yeardata) foreach ($yeardata as $daydata) $r []= $daydata;
		return $r;
	}

	public function listSingleYear($year)
	{
		return $this->staticData[$year];
	}

	public function listSingleYearAssociative($year)
	{
		$all = $this->listSingleYear($year);

		$result = array_fill(0, 25, null);

		foreach ($all as $d)
		{
			$result[$d['day'] - 1] = $d;
		}

		return $result;
	}

	public function listYears()
	{
		return array_keys($this->staticData);
	}

	private static function readSingle($year, $a)
	{
		$yeardata = self::YEARS[$year];

		$a['single_solution_file'] = $yeardata['single_solution_file'];

		$n2p = str_pad($a['day'], 2, '0', STR_PAD_LEFT);
		$a['day-padded'] = $n2p;

		$a['url']          = '/blog/' . $yeardata['blog-id'] . '/Advent_of_Code_' . $year . '/day-' . $n2p;
		$a['url-alternative'] = '/adventofcode/' . $year . '/' . $n2p;
		$a['canonical'] = "https://www.mikescher.com" . $a['url'];

		$a['url_aoc']    = $yeardata['url-aoc'] . $a['day']; // adventofcode.com/{year}/day/{day}

		$a['file_challenge'] = (__DIR__ . '/../../statics/aoc/'.$year.'/'.$n2p.'_challenge.txt');
		$a['file_input']     = (__DIR__ . '/../../statics/aoc/'.$year.'/'.$n2p.'_input.txt');

		$a['year']     = $year;
		$a['date']     = $year . '-' . 12 . '-' . $n2p;

		$solutionfiles = [];

		if ($a['single_solution_file'])
		{
			$solutionfiles []= (__DIR__ . '/../../statics/aoc/' . $year . '/' . $n2p . '_solution' . '.' . self::LANGUAGES[$a['language']]['ext']);
		}
		else
		{
			for ($i=1; $i <= $a['parts']; $i++)
			{
				$solutionfiles []= (__DIR__ . '/../../statics/aoc/' . $year . '/' . $n2p . '_solution-' . $i . '.' . self::LANGUAGES[$a['language']]['ext']);
			}
		}

		$a['file_solutions'] = $solutionfiles;

		return $a;
	}

	public function getDayFromStrIdent($year, $ident)
	{
		$e = explode('-', $ident, 2); // day-xxx
		if (count($e)!==2) return null;

		$i = intval($e[1], 10);
		if ($i == 0) return null;

		return self::getSingleDay($year, $i);
	}

	public function getSingleDay($year, $day)
	{
		foreach ($this->listSingleYear($year) as $aocd) {
			if ($aocd['day'] == $day) return $aocd;
		}
		return null;
	}

	public function getGithubLink($year)
	{
		return self::YEARS['' . $year]['github'];
	}

	public function getURLForYear($year)
	{
		return '/blog/' . self::YEARS[''.$year]['blog-id'] . '/Advent_of_Code_' . $year . '/';
	}

	public function getPrevYear($year)
	{
		$last = null;
		foreach (self::YEARS as $y => $d)
		{
			if ($y == $year) return $last;
			$last = $y;
		}
		return null;
	}

	public function getNextYear($year)
	{
		$found = false;
		foreach (self::YEARS as $y => $d)
		{
			if ($found) return $y;
			if ($y == $year) $found = true;
		}
		return null;
	}

	public function getLanguageCSS($data)
	{
		return self::LANGUAGES[$data['language']]['css'];
	}

	public function getSolutionCode($data, $i)
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

	public function checkConsistency()
	{
		$warn = null;

		$this->load();

		foreach ($this->listAllFromAllYears() as $year => $yd)
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

				if ($aocdata['day'] < 1 || $aocdata['day'] > 25) return ['result'=>'err', 'message' => 'Invalid [day]-value title ' . $aocdata['day']];

				if (count($aocdata['solutions']) !== $aocdata['parts'])      return ['result'=>'err', 'message' => 'Not enough solution-values in day' . $aocdata['day']];

				if ($aocdata['single_solution_file']) {
					if (count($aocdata['file_solutions']) !== 1) return ['result'=>'err', 'message' => 'Not enough solution-files in day' . $aocdata['day']];
				} else {
					if (count($aocdata['file_solutions']) !== $aocdata['parts']) return ['result'=>'err', 'message' => 'Not enough solution-files in day' . $aocdata['day']];
				}

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