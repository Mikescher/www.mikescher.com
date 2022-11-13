<?php

class Programs implements IWebsiteModule
{
	const PROG_LANGS = [ 'Java', 'C#', 'Delphi', 'PHP', 'C++', 'Rust', 'Typescript', 'Go' ];

	const URL_ORDER =
	[
		'github',
		'sourceforge',

		'download',
		'playstore',
		'amazonappstore',
		'windowsstore',
		'itunesstore',

		'docker',

		'aur-bin',
		'aur-git',
		'homebrew',
		'homebrew-tap',
		'chocolatey',

		'homepage',
		'wiki',
		'alternativeto',

		'changelog',
	];

	const LICENSES =
	[
		'MIT'         => 'https://choosealicense.com/licenses/mit/',
		'Unlicense'   => 'https://choosealicense.com/licenses/unlicense/',
		'GPL-3.0'     => 'https://choosealicense.com/licenses/gpl-3.0/',
		'Apache-2.0'  => 'https://choosealicense.com/licenses/apache-2.0/',
		'Mozilla-2.0' => 'https://choosealicense.com/licenses/mpl-2.0/',
	];

	/** @var array */
	private $staticData;

	public function __construct()
	{
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/programs/__all.php');

		$this->staticData = array_map(function($a){return self::readSingle($a);}, $all);
	}

	private static function readSingle($a)
	{
		$a['mainimage_url']        =              '/data/images/program_img/' . $a['internal_name'] . '.png';
		$a['mainimage_path']       = __DIR__ . '/../../data/images/program_img/' . $a['internal_name'] . '.png';

		$a['preview_url']          =              '/data/dynamic/progprev_' . $a['internal_name'] . '.png';
		$a['preview_path']         = __DIR__ . '/../../data/dynamic/progprev_' . $a['internal_name'] . '.png';

		$a['file_longdescription'] = (__DIR__ . '/../../statics/programs/' . $a['internal_name'] . '_description.md');

		$a['url']                  = '/programs/view/' . $a['internal_name'];

		$a['has_extra_images']     = array_key_exists('extra_images', $a) && count($a['extra_images'])>0;

		$a['extraimages_urls']  = [];
		$a['extraimages_paths'] = [];

		if ($a['has_extra_images'])
		{
			foreach ($a['extra_images'] as $fn)
			{
				$a['extraimages_urls']  []=                 '/data/images/program_img/' . $fn;
				$a['extraimages_paths'] []= __DIR__ . '/../../data/images/program_img/' . $fn;
			}
		}

		return $a;
	}

	public function listAll()
	{
		return $this->staticData;
	}

	public function listAllNewestFirst($filter = '')
	{
		$data = $this->staticData;
		usort($data, function($a, $b) { return strcasecmp($b['add_date'], $a['add_date']); });
		if ($filter !== '') $data = array_filter($data, function($a) use($filter) { return strtolower($a['category']) === strtolower($filter); });
		return $data;
	}

	public function getProgramByInternalName($id)
	{
		foreach ($this->staticData as $prog) {
			if (strcasecmp($prog['internal_name'], $id) === 0) return $prog;
			if ($prog['internal_name_alt'] !== null && strcasecmp($prog['internal_name_alt'], $id) === 0) return $prog;
		}
		return null;
	}

	public function getProgramDescription($prog)
	{
		return file_get_contents($prog['file_longdescription']);
	}

	private static function urlComparator($a, $b)
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

	public function getURLs($prog)
	{
		$urls = $prog['urls'];
		uksort($urls, function($a,$b){return self::urlComparator($a,$b);});

		$result = [];
		foreach ($urls as $fulltype => $urldata)
		{
			$type = $fulltype;
			if (strpos($fulltype, '#') !== FALSE) $type=explode('#', $fulltype)[0];

			$caption = '?';
			$css     = '?';
			$svg     = '?';
			$direct  = false;
			$alert   = null;

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
			if ($type === 'changelog')      { $caption = 'Changelog';        $css = 'prgv_dl_changelog';     $svg = 'changelog';     }

			if ($type === 'docker')         { $caption = 'Docker';           $css = 'prgv_dl_docker';        $svg = 'docker';        }
			if ($type === 'aur-bin')        { $caption = 'AUR (bin)';        $css = 'prgv_dl_aur_bin';       $svg = 'arch';          }
			if ($type === 'aur-git')        { $caption = 'AUR (git)';        $css = 'prgv_dl_aur_git';       $svg = 'arch';          }
			if ($type === 'homebrew')       { $caption = 'Homebrew';         $css = 'prgv_dl_homebrew';      $svg = 'homebrew';      }
			if ($type === 'homebrew-tap')   { $caption = 'Homebrew';         $css = 'prgv_dl_homebrew';      $svg = 'homebrew';      }
			if ($type === 'chocolatey')     { $caption = 'Chocolatey';       $css = 'prgv_dl_chocolatey';    $svg = 'chocolatey';    }

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

			if ($type === 'homebrew-tap')
			{
				$alert = $url;
				$url = '';
			}

			$result []=
			[
				'type'     => $type,
				'caption'  => $caption,
				'svg'      => $svg,
				'href'     => $url,
				'css'      => $css,
				'isdirect' => $direct,
				'alert'    => $alert,
			];
		}

		return $result;
	}

	public function getLicenseUrl($license)
	{
		return self::LICENSES[$license];
	}

	public function getDirectDownloadURL($prog)
	{
		return '/data/binaries/'.$prog['internal_name'].'.zip';
	}

	public function getDirectDownloadPath($prog)
	{
		return (__DIR__ . '/../../data/binaries/'.$prog['internal_name'].'.zip');
	}

	public function checkConsistency()
	{
		$warn = null;

		$this->load();

		$intname = [];
		$realname = [];

		foreach ($this->staticData as $prog)
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

			foreach (explode_allow_empty('|', $prog['ui_language']) as $lang) if ($this->convertLanguageToFlag($lang) === null) return ['result'=>'err', 'message' => 'Unknown ui-lang ' . $prog['name']];

			if (!in_array($prog['prog_language'], self::PROG_LANGS)) return ['result'=>'err', 'message' => 'Unknown prog-lang ' . $prog['name']];

			if (strlen($prog['short_description'])> 128) $warn = ['result'=>'warn', 'message' => 'short_description too long ' . $prog['name']];

			if ($prog['license'] !== null && !array_key_exists($prog['license'], self::LICENSES)) return ['result'=>'err', 'message' => 'Unknown license ' . $prog['name']];

			$isdl = false;
			foreach ($this->getURLs($prog) as $xurl)
			{
				if (!in_array($xurl['type'], self::URL_ORDER)) return ['result'=>'err', 'message' => 'Unknown url ' . $xurl['type']];

				if ($xurl['type']==='download' && $xurl['isdirect'] && !file_exists($this->getDirectDownloadPath($prog))) return ['result'=>'err', 'message' => 'Direct download not found ' . $prog['name']];

				if (in_array($xurl['type'], ['download', 'playstore', 'itunesstore', 'docker', 'aur-bin', 'aur-git', 'homebrew', 'chocolatey'])) $isdl = true;
			}

			if (!$isdl) return ['result'=>'err', 'message' => 'No download link ' . $prog['name']];

			if (!file_exists($prog['mainimage_path'])) return ['result'=>'err', 'message' => 'Image not found ' . $prog['name']];

			if (!file_exists($prog['file_longdescription'])) return ['result'=>'err', 'message' => 'Description not found ' . $prog['name']];

			foreach ($prog['extraimages_paths'] as $eipath)
			{
				if (!file_exists($eipath)) return ['result'=>'err', 'message' => 'Extra-Image not found ' . $prog['name'], 'long' => $eipath];
			}

			if (!file_exists($prog['preview_path'])) $warn = ['result'=>'warn', 'message' => 'Preview not found ' . $prog['name']];
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}

	public function createPreview($prog)
	{
		$src = $prog['mainimage_path'];
		$dst = $prog['preview_path'];

		if (Website::inst()->config['use_magick'])
			magick_resize_image($src, 250, 0, $dst);
		else
			smart_resize_image($src, 250, 0, true, $dst);
	}

	public function convertLanguageToFlag($lang) {
		$lang = trim(strtolower($lang));

		if ($lang === 'italian')     return '/data/images/flags/013-italy.svg';
		if ($lang === 'english')     return '/data/images/flags/226-united-states.svg';
		if ($lang === 'french')      return '/data/images/flags/195-france.svg';
		if ($lang === 'german')      return '/data/images/flags/162-germany.svg';
		if ($lang === 'spanish')     return '/data/images/flags/128-spain.svg';

		return null;
	}
}