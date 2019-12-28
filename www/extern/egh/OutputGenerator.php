<?php

require_once 'Utils.php';
require_once 'EGGDatabase.php';

interface IOutputGenerator
{
	/**
	 * @param $db EGGDatabase
	 * @return string|null
	 */
	public function updateCache(EGGDatabase $db);

	/**
	 * @return string|null
	 */
	public function loadFromCache();
}

class FullRenderer implements IOutputGenerator
{
	/** @var ILogger $logger */
	private $logger;

	/** @var string[] $identities */
	private $identities;

	/** @var string $cache_files_path */
	private $cache_files_path;

	/**
	 * @param ILogger $logger
	 * @param string[] $identities
	 * @param string $cfpath
	 */
	public function __construct(ILogger $logger, array $identities, string $cfpath)
	{
		$this->logger           = $logger;
		$this->identities       = $identities;
		$this->cache_files_path = $cfpath;
	}

	/**
	 * @inheritDoc
	 */
	public function updateCache(EGGDatabase $db)
	{
		$years = $db->getAllYears();
		$dyears = [];

		$result = "";
		foreach ($years as $year)
		{
			$gen = new SingleYearRenderer($this->logger, $year, $this->identities, $this->cache_files_path);
			$cc = $gen->updateCache($db);
			if ($cc === null) continue;

			$result .= $cc;
			$result .= "\n\n\n";

			$dyears []= $year;
		}

		$data = json_encode($dyears);

		$path = Utils::sharpFormat($this->cache_files_path, ['ident' => 'fullrenderer']);

		file_put_contents($path, $data);
		$this->logger->proclog("Updated cache file for full renderer");

		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function loadFromCache()
	{
		$path = Utils::sharpFormat($this->cache_files_path, ['ident' => 'fullrenderer']);
		if (!file_exists($path))
		{
			$this->logger->proclog("No cache found for [fullrenderer]");
			return null;
		}

		$years = json_decode(file_get_contents($path));

		$result = "";

		foreach ($years as $year)
		{
			$gen = new SingleYearRenderer($this->logger, $year, $this->identities, $this->cache_files_path);
			$cc = $gen->loadFromCache();
			if ($cc === null) return null;
			$result .= $cc;
			$result .= "\n\n\n";
		}
		return $result;
	}
}

class SingleYearRenderer implements IOutputGenerator
{
	const DIST_X     = 13;
	const DIST_Y     = 13;
	const DAY_WIDTH  = 11;
	const DAY_HEIGHT = 11;

	const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	const DAYS   = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

	/** @var ILogger $logger */
	private $logger;

	/** @var int $year */
	private $year;

	/** @var string[] $identities */
	private $identities;

	/** @var string $cache_files_path */
	private $cache_files_path;

	/**
	 * @param ILogger $logger
	 * @param int $year
	 * @param string[] $identities
	 * @param string $cfpath
	 */
	public function __construct(ILogger $logger, int $year, array $identities, string $cfpath)
	{
		$this->logger           = $logger;
		$this->year             = $year;
		$this->identities       = $identities;
		$this->cache_files_path = $cfpath;
	}

	/**
	 * @inheritDoc
	 */
	public function loadFromCache()
	{
		$path = Utils::sharpFormat($this->cache_files_path, ['ident' => 'singleyear_'.$this->year]);
		if (!file_exists($path))
		{
			$this->logger->proclog("No cache found for [".('singleyear_'.$this->year)."]");
			return null;
		}
		return file_get_contents($path);
	}

	/**
	 * @inheritDoc
	 */
	public function updateCache(EGGDatabase $db)
	{
		$this->logger->proclog("Generate cache file for year ".$this->year);
		$data = $this->generate($db);

		if ($data === null) {
			$this->logger->proclog("No data for year ".$this->year);
			$this->logger->proclog("");
			return null;
		}

		$path = Utils::sharpFormat($this->cache_files_path, ['ident' => 'singleyear_'.$this->year]);

		file_put_contents($path, $data);
		$this->logger->proclog("Updated cache file for year ".$this->year);
		$this->logger->proclog("");

		return $data;
	}

	/**
	 * @param EGGDatabase $db
	 * @return string|null
	 * @throws Exception
	 */
	private function generate(EGGDatabase $db)
	{
		$dbdata = $db->getCommitCountOfYearByDate($this->year, $this->identities);

		if (Utils::array_value_max(0, $dbdata) === 0) return null;

		$now = new DateTime();
		$date = new DateTime($this->year . '-01-01');
		$ymapmax = Utils::array_value_max(1, $dbdata);

		$monthlist = array_fill(0, 12, [0, 0]);

		$exponent9 = log(0.98/((9)-1), 1/$ymapmax);
		$exponent5 = log(0.98/((5)-1), 1/$ymapmax);


		$html = '';

		$html .= '<div class="extGitGraphContainer">' . "\n";
		$html .= '<svg class="git_list" viewBox="0 0 715 115">' . "\n";
		$html .= '<g transform="translate(20, 20) ">' . "\n";
		$html .= '<g transform="translate(0, 0)">' . "\n";

		$week = 0;
		$wday = 0;
		while($date->format('Y') == $this->year)
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

			$c_count = array_key_exists($date->format('Y-m-d'), $dbdata) ? $dbdata[$date->format('Y-m-d')] : 0;
			$color_idx9 = min(((9)-1), ceil(pow($c_count/$ymapmax, $exponent9) * ((9)-1)));
			$color_idx5 = min(((5)-1), ceil(pow($c_count/$ymapmax, $exponent5) * ((5)-1)));

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
				' y="'               . ($wday * self::DIST_Y)                                        . '"' .
				' height="'          . self::DAY_HEIGHT                                              . '"' .
				' width="'           . self::DAY_WIDTH                                               . '"' .
				' class="'           . 'egg_rect egg_col_x5_'.$color_idx5.' egg_col_x9_'.$color_idx9 . '"' .
				' data-count="'      . $c_count                                                      . '"' .
				' data-date="'       . $date->format('Y-m-d')                                        . '"' .
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

		$html .=  '<text  x="-10" y="-5" class="caption">' . $this->year . '</text>' . "\n";

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