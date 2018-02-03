<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once __DIR__ . '/base.php';

class Programs
{
	const PROG_LANGS = [ 'Java', 'C#', 'Delphi', 'PHP', 'C++' ];

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
		$a['mainimage_url']        =              '/data/images/program_img/' . $a['internal_name'] . '.png';
		$a['mainimage_path']       = __DIR__ . '/../data/images/program_img/' . $a['internal_name'] . '.png';

		$a['preview_url']          =              '/data/dynamic/progprev_' . $a['internal_name'] . '.png';
		$a['preview_path']         = __DIR__ . '/../data/dynamic/progprev_' . $a['internal_name'] . '.png';

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
		$a = require (__DIR__ . '/../statics/updates/_all.php');
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
		$na = 0;
		$nb = 0;

		if (strpos($a, '#') !== FALSE) { $na = intval(explode('#', $a)[1]); $a=explode('#', $a)[0]; }
		if (strpos($b, '#') !== FALSE) { $nb = intval(explode('#', $b)[1]); $b=explode('#', $b)[0]; }

		$ia = array_search($a, Programs::URL_ORDER);
		$ib = array_search($b, Programs::URL_ORDER);

		if ($ia === false && $ib === false) return strcasecmp($a, $b);
		if ($ia === false && $ib !== false) return +1; // sort [IA | IB]
		if ($ia !== false && $ib === false) return -1; // sort [IB | IA]

		if ($ia === $ib) return ($na < $nb) ? -1 : +1;

		return ($ia < $ib) ? -1 : +1;

	}

	public static function getURLs($prog)
	{
		$urls = $prog['urls'];
		uksort($urls, 'self::urlComparator');

		$result = [];
		foreach ($urls as $fulltype => $urldata)
		{
			$type = $fulltype;
			if (strpos($fulltype, '#') !== FALSE) $type=explode('#', $fulltype)[0];

			$caption = '?';
			$css     = '?';
			$svg     = '?';
			$direct  = false;

			if ($type === 'download')       { $caption = 'Download';         $css = 'prgv_dl_download';      $svg = 'download';      }
			if ($type === 'github')         { $caption = 'Github';           $css = 'prgv_dl_github';        $svg = 'github';        }
			if ($type === 'homepage')       { $caption = 'Homepage';         $css = 'prgv_dl_homepage';      $svg = 'home';          }
			if ($type === 'wiki')           { $caption = 'Wiki';             $css = 'prgv_dl_wiki';          $svg = 'wiki';          }
			if ($type === 'playstore')      { $caption = 'Google Playstore'; $css = 'prgv_dl_playstore';     $svg = 'playstore';     }
			if ($type === 'amazonappstore') { $caption = 'Amazon Appstore';  $css = 'prgv_dl_amznstore';     $svg = 'amazon';        }
			if ($type === 'windowsstore')   { $caption = 'Microsoft Store';  $css = 'prgv_dl_winstore';      $svg = 'windows';       }
			if ($type === 'itunesstore')    { $caption = 'App Store';        $css = 'prgv_dl_appstore';      $svg = 'apple';         }
			if ($type === 'sourceforge')    { $caption = 'Sourceforge';      $css = 'prgv_dl_sourceforge';   $svg = 'sourceforge';   }
			if ($type === 'alternativeto')  { $caption = 'AlternativeTo';    $css = 'prgv_dl_alternativeto'; $svg = 'alternativeto'; }

			if (is_array($urldata))
			{
				$url = $urldata['url'];
				if (isset($urldata['caption'])) $caption = $urldata['caption'];
				if (isset($urldata['css']))     $css     = $urldata['css'];
				if (isset($urldata['svg']))     $svg     = $urldata['svg'];
			}
			else
			{
				$url = $urldata;
			}

			if ($url === 'direct')
			{
				$direct = true;
				$url    =  Programs::getDirectDownloadURL($prog);
			}

			$result []=
			[
				'type'     => $type,
				'caption'  => $caption,
				'svg'      => $svg,
				'href'     => $url,
				'css'      => $css,
				'isdirect' => $direct,
			];
		}

		return $result;
	}

	public static function getLicenseUrl($license)
	{
		return self::LICENSES[$license];
	}

	public static function getDirectDownloadURL($prog)
	{
		return '/data/binaries/'.$prog['internal_name'].'.zip';
	}

	public static function getDirectDownloadPath($prog)
	{
		return (__DIR__ . '/../data/binaries/'.$prog['internal_name'].'.zip');
	}

	public static function checkConsistency()
	{
		$warn = null;

		$intname = [];
		$realname = [];

		foreach (self::listAll() as $prog)
		{
			if (in_array($prog['internal_name'], $intname)) return ['result'=>'err', 'message' => 'Duplicate internal_name ' . $prog['name']];
			$intname []= $prog['internal_name'];

			if ($prog['internal_name_alt'] !== null)
			{
				if (in_array($prog['internal_name_alt'], $intname)) return ['result'=>'err', 'message' => 'Duplicate internal_name ' . $prog['name']];
				$intname []= $prog['internal_name_alt'];
			}

			if (in_array($prog['name'], $realname)) return ['result'=>'err', 'message' => 'Duplicate name ' . $prog['name']];
			$realname []= $prog['name'];

			if (strpos($prog['internal_name'], ' ') !== FALSE) return ['result'=>'err', 'message' => 'Internal name contains spaces ' . $prog['name']];

			foreach (explode('|', $prog['ui_language']) as $lang) if (convertLanguageToFlag($lang) === null) return ['result'=>'err', 'message' => 'Unknown ui-lang ' . $prog['name']];;

			if (!in_array($prog['prog_language'], self::PROG_LANGS)) return ['result'=>'err', 'message' => 'Unknown prog-lang ' . $prog['name']];

			if (strlen($prog['short_description'])> 128) $warn = ['result'=>'warn', 'message' => 'short_description too long ' . $prog['name']];

			if ($prog['license'] !== null && !array_key_exists($prog['license'], self::LICENSES)) return ['result'=>'err', 'message' => 'Unknown license ' . $prog['name']];

			$isdl = false;
			foreach (self::getURLs($prog) as $xurl)
			{
				if (!in_array($xurl['type'], self::URL_ORDER)) return ['result'=>'err', 'message' => 'Unknown url ' . $xurl['type']];

				if ($xurl['type']==='download' && $xurl['isdirect'] && !file_exists(self::getDirectDownloadPath($prog))) return ['result'=>'err', 'message' => 'Direct download not found ' . $prog['name']];

				if ($xurl['type']==='download' || $xurl['type']==='playstore' || $xurl['type']==='itunesstore') $isdl = true;
			}

			if (!$isdl) return ['result'=>'err', 'message' => 'No download link ' . $prog['name']];

			if (!file_exists($prog['mainimage_path'])) return ['result'=>'err', 'message' => 'Image not found ' . $prog['name']];

			if (!file_exists($prog['file_longdescription'])) return ['result'=>'err', 'message' => 'Description not found ' . $prog['name']];
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}

	public static function checkThumbnails()
	{
		foreach (self::listAll() as $prog)
		{
			if (!file_exists($prog['preview_path'])) return ['result'=>'err', 'message' => 'Preview not found ' . $prog['name']];
		}

		return ['result'=>'ok', 'message' => ''];
	}

	public static function createPreview($prog)
	{
		global $CONFIG;

		$src = $prog['mainimage_path'];
		$dst = $prog['preview_path'];

		if ($CONFIG['use_magick'])
			magick_resize_image($src, 250, 0, $dst);
		else
			smart_resize_image($src, 250, 0, true, $dst);
	}
}