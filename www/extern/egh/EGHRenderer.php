<?php

require_once 'ExtendedGitGraph.php';
require_once 'SingleCommitInfo.php';
require_once 'Utils.php';

class EGHRenderer
{
	const DIST_X     = 13;
	const DIST_Y     = 13;
	const DAY_WIDTH  = 11;
	const DAY_HEIGHT = 11;

	const COMMITCOUNT_COLOR_UPPERLIMIT = 16;

	const COLOR_SCHEMES =
		[
			'custom'    => ['#F5F5F5', '#DBDEE0', '#C2C7CB', '#AAB0B7', '#9099A2', '#77828E', '#5E6B79', '#455464', '#2C3E50'],
			'standard'  => ["#ebedf0", "#c6e48b", "#7bc96f", "#239a3b", "#196127"],
			'modern'    => ["#afaca8", "#d6e685", "#8cc665", "#44a340", "#1e6823"],
			'gray'      => ["#eeeeee", "#bdbdbd", "#9e9e9e", "#616161", "#212121"],
			'red'       => ["#eeeeee", "#ff7171", "#ff0000", "#b70000", "#830000"],
			'blue'      => ["#eeeeee", "#6bcdff", "#00a1f3", "#0079b7", "#003958"],
			'purple'    => ["#eeeeee", "#d2ace6", "#aa66cc", "#660099", "#4f2266"],
			'orange'    => ["#eeeeee", "#ffcc80", "#ffa726", "#fb8c00", "#e65100"],
			'halloween' => ["#eeeeee", "#ffee4a", "#ffc501", "#fe9600", "#03001c"],
		];

	const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	const DAYS   = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

	/* @var ExtendedGitGraph */
	private $owner;
	/* @var SingleCommitInfo[] */
	public $data;
	/* @var string */
	public $colorScheme = 'standard';
	/* @var int[] */
	public $yearList;
	/* @var array */
	public $commitMap; // date('Y-m-d') -> count

	public function __construct($egh) {
		$this->owner = $egh;
	}

	/**
	 * @param $data SingleCommitInfo[]
	 */
	public function init($data)
	{
		$this->data = $data;

		$this->yearList = $this->getYears($data);
		$this->owner->out("Found " . count($this->yearList) . " year to generate.");

		$this->commitMap = $this->generateCommitMap($data, $this->yearList);
		$this->owner->out("Commitmap with ".count($this->commitMap)." entries generated.");
	}

	/**
	 * @param $data SingleCommitInfo[]
	 * @return int[]
	 */
	public function getYears($data) {
		$years = array();

		foreach	($data as $commit) {
			if(! in_array($commit->Timestamp->format('Y'), $years))
				$years[] = intval($commit->Timestamp->format('Y'));
		}

		asort($years);

		return $years;
	}

	/**
	 * @param $data SingleCommitInfo[]
	 * @param $yearList int[]
	 * @return array
	 */
	private function generateCommitMap($data, $yearList)
	{
		$result = [];

		foreach ($yearList as $year)
		{
			$ymap = [];

			$date = new DateTime($year . '-01-01');
			while($date->format('Y') == $year)
			{
				$ymap[$date->format('Y-m-d')] = 0;
				$date = $date->modify("+1 day");
			}

			foreach	($data as $commit)
			{
				if(array_key_exists($commit->Timestamp->format('Y-m-d'), $ymap)) $ymap[$commit->Timestamp->format('Y-m-d')]++;
			}

			$result = array_merge($result, $ymap);
		}


		return $result;
	}

	/**
	 * @param $year int
	 * @return int
	 */
	private function getMaxCommitCount($year)
	{
		$max = 0;
		foreach ($this->commitMap as $date => $count) if (Utils::startsWith($date, strval($year))) $max = max($max, $count);
		return $max;
	}

	/**
	 * @param $year int
	 * @return string
	 */
	public function render($year)
	{
		$now = new DateTime();
		$date = new DateTime($year . '-01-01');
		$monthlist = array_fill(0, 12, [0, 0]);
		$colors = self::COLOR_SCHEMES[$this->colorScheme];

		$ymapmax = $this->getMaxCommitCount($year);
		$exponent = log(0.98/(count($colors)-1), 1/$ymapmax); // (1/max)^n = 0.98   // => 1 commit erreicht immer genau die erste stufe

		$html = '';

		$html .= '<div class="extGitGraphContainer">' . "\n";
		$html .= '<svg class="git_list" viewBox="0 0 715 115">' . "\n";
		$html .= '<g transform="translate(20, 20) ">' . "\n";
		$html .= '<g transform="translate(0, 0)">' . "\n";

		$week = 0;
		$wday = 0;
		while($date->format('Y') == $year)
		{
			if ($date > $now) // THE FUTURE, SPONGEBOB
			{
				while ($date->format('d') != $date->format('t'))
				{
					if ($date->format('N') == 1 && $date->format('z') > 0) $week++;
					$date = $date->modify("+1 day");
				}
				$monthlist[$date->format('m') - 1][1] = $week + ($wday / 7);

				$date = $date->modify("+1 year"); // Kill
				continue;
			}

			$c_count = $this->commitMap[$date->format('Y-m-d')];
			$color_idx = min((count($colors)-1), ceil(pow($c_count/$ymapmax, $exponent) * (count($colors)-1)));
			$color = $colors[$color_idx];

			$wday = ($date->format('N') - 1);

			if ($date->format('N') == 1 && $date->format('z') > 0)
			{
				$html .= '</g>' . "\n";
				$week++;
				$html .= '<g transform="translate(' . $week * self::DIST_X . ', 0)">' . "\n";
			}

			if ($date->format('d') == 1)
			{
				$monthlist[$date->format('m') - 1][0] = $week + ($wday / 7);
			}
			else if ($date->format('d') == $date->format('t'))
			{
				$monthlist[$date->format('m') - 1][1] = $week + ($wday / 7);
			}

			$html .=  '<rect'.
				' style='            .'"fill:'.$color.';'     . '"' .
				' y="'               . ($wday * self::DIST_Y) . '"' .
				' height="'          . self::DAY_HEIGHT       . '"' .
				' width="'           . self::DAY_WIDTH        . '"' .
				' class="'           . 'egg_rect'             . '"' .
				' data-count="'      . $c_count               . '"' .
				' data-date="' . ' ' . $date->format('Y-m-d') . '"' .
				'></rect>' . "\n";

			$date = $date->modify("+1 day");
		}

		$html .= '</g>' . "\n";

		for($i = 0; $i < 12; $i++)
		{
			if ($monthlist[$i][1]-$monthlist[$i][0] > 0)
			{
				$posx = (($monthlist[$i][0]+$monthlist[$i][1])/2) * self::DIST_X;
				$html .=  '<text y="-3" x="' . $posx . '" style="text-anchor: middle" class="caption_month">' . self::MONTHS[$i] . '</text>' . "\n";
			}
		}

		for($i = 0; $i < 7; $i++) {
			$html .=  '<text y="' . ($i*self::DIST_Y + self::DAY_HEIGHT/2) . '" x="-6" style="text-anchor: middle" class="caption_day" dominant-baseline="central">' . self::DAYS[$i] . '</text>' . "\n";
		}

		$html .=  '<text  x="-10" y="-5" class="caption">' . $year . '</text>' . "\n";

		$html .= '</g>' . "\n";
		$html .= '</svg>' . "\n";
		$html .= '<div class="svg-tip n">' . "\n";
		$html .= '<strong>&nbsp;</strong><span>&nbsp;</span>' . "\n";
		$html .= '</div>' . "\n";
		$html .= '<div class="egg_footer">' . "\n";
		$html .= '<a href="https://www.mikescher.com/programs/view/ExtendedGitGraph">extendedGitGraph</a>' . "\n";
		$html .= '</div>' . "\n";
		$html .= '</div>' . "\n";


		return $html;
	}
}