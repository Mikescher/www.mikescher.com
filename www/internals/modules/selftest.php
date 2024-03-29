<?php

class SelfTest implements IWebsiteModule
{
	private const STATUS_ERROR = 2;
	private const STATUS_WARN  = 1;
	private const STATUS_OK    = 0;

	private const DISPLAY_NAMES =
	[
		'web::main'                => 'Website (http)',
		'web::programs'            => 'Programs (http)',
		'web::programs-ext'        => 'Programs (links)',
		'web::programs-dl'         => 'Programs (download)',
		'web::books'               => 'Books (http)',
		'web::blog'                => 'Blog (http)',
		'web::webapps'             => 'WebApps (http)',
		'web::euler'               => 'Project Euler (http)',
		'web::aoc'                 => 'Advent of Code (http)',
		'api::default'             => 'API',
		'api::highscore'           => 'Highscores API',
		'modules::database'        => 'Database',
		'modules::blog'            => 'Blog (data)',
		'modules::euler'           => 'Project Euler (data)',
		'modules::books'           => 'Books (data)',
		'modules::extgitgraph'     => 'ExtendedGitGraph (data)',
		'modules::programs'        => 'Programs (data)',
		'modules::adventofcode'    => 'Advent of Code (data)',
		'modules::anstatistics'    => 'AlephNote Stats (data)',
		'modules::updateslog'      => 'Program Updates (data)',
		'modules::webapps'         => 'Webapps (data)',
        'modules::highscores'      => 'Highscores (data)',
        'modules::projectlawful'   => 'ProjectLawful-ebook (files)',
		'egg::db-check'            => 'ExtendedGitGraph (db-check)',
		'backend::git'             => 'Git Repository',
	];

	private $methods = [];

	public function __construct()
	{
		$this->init();
	}

	private function init()
	{
		$this->addMethodPathStatus("web::main::index-1",    200, '');
		$this->addMethodPathStatus("web::main::index-2",    200, '/index');
		$this->addMethodPathStatus("web::main::index-3",    200, '/index.php');
		$this->addMethodPathStatus("web::main::index-4",    200, '/msmain/index');
		$this->addMethodPathStatus("web::main::about-1",    200, '/about');
		$this->addMethodPathStatus("web::main::about-2",    200, '/msmain/about');
		$this->addMethodPathStatus("web::main::login-1",    200, '/login');
		$this->addMethodPathStatus("web::main::404-1",      404, '/asdf');
		$this->addHTTPSRedirect(   "web::main::redirect-1",      '');
		$this->addHTTPSRedirect(   "web::main::redirect-2",      '/about');
		$this->addHTTPSRedirect(   "web::main::redirect-3",      '/about');

		$this->addMethodPathStatus(     "web::programs::programs-list-1",     200, '/programs');
		$this->addMethodPathStatus(     "web::programs::programs-list-2",     200, '/programs/index');
		$this->addMethodPathStatus(     "web::programs::programs-list-3",     200, '/downloads/details.php');
		$this->addMethodPathStatus(     "web::programs::programs-list-4",     200, '/downloads/downloads.php');
		$this->addMethodMultiPathStatus("web::programs::programs-filtered-1", 200, '/programs/index?categoryfilter={0}', function(){ return array_key_map_unique(Website::inst()->modules->Programs()->listAll(), 'category'); });
		$this->addMethodMultiPathStatus("web::programs::programs-filtered-2", 200, '/programs/cat/{0}', function(){ return array_key_map_unique(Website::inst()->modules->Programs()->listAll(), 'category'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-1",     200, '/programs/view/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-2",     200, '/programs/view?id={0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-3",     200, '{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'url'); });
		$this->addMethodPathStatus(     "web::programs::programs-404-1",      404, '/programs/view/asdf_not_found');
		$this->addMethodPathStatus(     "web::programs::programs-404-2",      404, '/programs/download/asdf_not_found');

		$this->addMethodMultiPathStatus("web::programs-dl::programs-download-1", 302, '/downloads/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs-dl::programs-download-2", 302, '/programs/download/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs-dl::programs-download-3", 302, '/programs/download?id={0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });

		$this->addMethodExtProgLinks(   "web::programs-ext::programs-ext-links");

		$this->addMethodPathStatus(     "web::books::books-list-1", 200, '/books');
		$this->addMethodPathStatus(     "web::books::books-list-2", 200, '/books/list');
		$this->addMethodMultiPathStatus("web::books::books-show-1", 200, '/books/view/{0}', function(){ return array_key_map(Website::inst()->modules->Books()->listAll(), 'id'); });
		$this->addMethodMultiPathStatus("web::books::books-show-2", 200, '{0}', function(){ return array_key_map(Website::inst()->modules->Books()->listAll(), 'url'); });
		$this->addMethodPathStatus(     "web::books::books-404-1",  404, '/books/view/asdf/not_found');

		$this->addMethodPathStatus(     "web::blog::blog-list-1", 200, '/blog');
		$this->addMethodPathStatus(     "web::blog::blog-list-2", 200, '/log');
		$this->addMethodPathStatus(     "web::blog::blog-list-3", 200, '/blogpost/index');
		$this->addMethodMultiPathStatus("web::blog::blog-show-1", 200, '/blog/{0}', function(){ return array_key_map(Website::inst()->modules->Blog()->listAll(), 'id'); });
		$this->addMethodMultiPathStatus("web::blog::blog-show-2", 200, '/log/{0}', function(){ return array_key_map(Website::inst()->modules->Blog()->listAll(), 'id'); });
		$this->addMethodMultiPathStatus("web::blog::blog-show-3", 200, '/blogpost/view?id={0}', function(){ return array_key_map(Website::inst()->modules->Blog()->listAll(), 'id'); });
		$this->addMethodMultiPathStatus("web::blog::blog-show-4", 200, '{0}', function(){ return array_key_map(Website::inst()->modules->Blog()->listAll(), 'url'); });
		$this->addMethodPathStatus(     "web::blog::blog-404-1",  404, '/blog/999999');
		$this->addMethodPathStatus(     "web::blog::blog-404-2",  404, '/blog/999999/Notfound');
		$this->addMethodPathStatus(     "web::blog::blog-404-3",  404, '/blog/asdf');

		$this->addMethodPathStatus("web::webapps::webapps-list-1", 200, '/webapps');

		$this->addMethodPathStatus(     "web::euler::euler-list-1", 200, '/blog/1/Project_Euler_with_Befunge');
		$this->addMethodMultiPathStatus("web::euler::euler-show-1", 200, '{0}', function(){ return array_key_map(Website::inst()->modules->Euler()->listAll(), 'url'); });
		$this->addMethodPathStatus(     "web::euler::euler-404-1",  404, '/blog/1/Project_Euler_with_Befunge/problem-A');
		$this->addMethodPathStatus(     "web::euler::euler-404-2",  404, '/blog/1/Project_Euler_with_Befunge/problem-99999');
		$this->addMethodPathStatus(     "web::euler::euler-404-3",  404, '/blog/1/Project_Euler_with_Befunge/asdf');

		$this->addMethodMultiPathStatus("web::aoc::aoc-list-1",     200, '{0}', function(){ return array_map(function($x){return Website::inst()->modules->AdventOfCode()->getURLForYear($x);},Website::inst()->modules->AdventOfCode()->listYears()); });
		$this->addMethodMultiPathStatus("web::aoc::aoc-show-1",     200, '{0}', function(){ return array_key_map(Website::inst()->modules->AdventOfCode()->listAllDays(), 'url'); });
		$this->addMethodPathStatus(     "web::aoc::aoc-404-1",      404, '/blog/25/Advent_of_Code_2017/day-26');
		$this->addMethodPathStatus(     "web::aoc::aoc-404-2",      404, '/blog/23/Advent_of_Code_2018/day-27');
		$this->addMethodPathStatus(     "web::aoc::aoc-404-3",      404, '/blog/24/Advent_of_Code_2019/day-28');
		$this->addMethodMultiPathStatus("web::aoc::aoc-redirect-1", 302, '{0}', function(){ return array_key_map(Website::inst()->modules->AdventOfCode()->listAllDays(), 'url-alternative'); });
		$this->addMethodMultiPathStatus("web::aoc::aoc-redirect-1", 302, '/adventofcode/{0}', function(){ return Website::inst()->modules->AdventOfCode()->listYears(); });

		$this->addCheckConsistency("modules::database::database-check-consistency",               function(){ return Website::inst()->modules->Database(); });
		$this->addCheckConsistency("modules::blog::blog-check-consistency",                       function(){ return Website::inst()->modules->Blog(); });
		$this->addCheckConsistency("modules::euler::euler-check-consistency",                     function(){ return Website::inst()->modules->Euler(); });
		$this->addCheckConsistency("modules::books::books-check-consistency",                     function(){ return Website::inst()->modules->Books(); });
		$this->addCheckConsistency("modules::extgitgraph::extgitgraph-check-consistency",         function(){ return Website::inst()->modules->ExtendedGitGraph(); });
		$this->addCheckConsistency("modules::programs::programs-check-consistency",               function(){ return Website::inst()->modules->Programs(); });
		$this->addCheckConsistency("modules::books::books-check-consistency",                     function(){ return Website::inst()->modules->Books(); });
		$this->addCheckConsistency("modules::adventofcode::adventofcode-check-consistency",       function(){ return Website::inst()->modules->AdventOfCode(); });
		$this->addCheckConsistency("modules::anstatistics::anstatistics-check-consistency",       function(){ return Website::inst()->modules->AlephNoteStatistics(); });
		$this->addCheckConsistency("modules::updateslog::updateslog-check-consistency",           function(){ return Website::inst()->modules->UpdatesLog(); });
		$this->addCheckConsistency("modules::webapps::webapps-check-consistency",                 function(){ return Website::inst()->modules->WebApps(); });
        $this->addCheckConsistency("modules::highscores::highscores-check-consistency",           function(){ return Website::inst()->modules->Highscores(); });
        $this->addCheckConsistency("modules::projectlawful::projectlawful-check-consistency",     function(){ return Website::inst()->modules->ProjectLawful(); });

		$this->addLambdaStatus("egg::db-check::check-db-consistency", function(){ return Website::inst()->modules->ExtendedGitGraph()->checkDatabaseConsistency(); });

		$ajaxsecret = Website::inst()->config['ajax_secret'];

		$this->addMethodPathResponse(   "api::default::base-test-2",   200,  '{}', '/api/test');
		$this->addMethodPathResponse(   "api::default::base-test-4",   200,  '{}', '/api/base::test');
		$this->addMethodMultiPathStatus("api::default::updatecheck-1", 200, '/update.php?name={0}', function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-2", 200, '/update.php/{0}',      function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-3", 200, '/update?name={0}',     function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-4", 200, '/update/{0}',          function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-5", 200, '/update2?name={0}',    function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-6", 200, '/api/update?name={0}', function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodMultiPathStatus("api::default::updatecheck-7", 200, '/api/update/{0}',      function(){ return array_keys(Website::inst()->modules->UpdatesLog()->listUpdateData()); });
		$this->addMethodPathStatus(     "api::default::egg-status",    200, "/api/extendedgitgraph::status?secret=$ajaxsecret");
		$this->addMethodPathStatus(     "api::default::an-show",       200, "/api/alephnote::show?secret=$ajaxsecret");
		$this->addMethodMultiPathStatus("api::default::updates-show",  200, "/api/updates::show?secret=$ajaxsecret&ulname={0}", function(){ return array_key_map(Website::inst()->modules->UpdatesLog()->listProgramsInformation(), 'name'); });
		$this->addMethodPathStatus(     "api::default::aoc-ajax-1",    200, "/api/html::panel_aoc_calendar?year=2017&nav=true&linkheader=true&ajax=true&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-2",    200, "/api/html::panel_aoc_calendar?year=2018&nav=true&linkheader=true&ajax=true&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-3",    200, "/api/html::panel_aoc_calendar?year=2019&nav=true&linkheader=true&ajax=true&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-4",    200, "/api/html::panel_aoc_calendar?year=2019&nav=false&linkheader=true&ajax=true&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-5",    200, "/api/html::panel_aoc_calendar?year=2019&nav=true&linkheader=false&ajax=true&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-6",    200, "/api/html::panel_aoc_calendar?year=2019&nav=true&linkheader=true&ajax=false&frameid=x");
		$this->addMethodPathStatus(     "api::default::aoc-ajax-7",    200, "/api/html::panel_aoc_calendar?year=2019&nav=false&linkheader=false&ajax=false&frameid=x");
		$this->addMethodPathStatus(     "api::default::api-404-1",     404, '/api/update/no_prog_xx');
		$this->addMethodPathStatus(     "api::default::api-404-2",     404, '/api/asdf::notfound');

		$this->addMethodPathStatus(     "api::highscore::listgames-1",   200, "/highscores/list.php");
		$this->addMethodPathStatus(     "api::highscore::listgames-2",   200, "/highscores/list");
		$this->addMethodPathStatus(     "api::highscore::listgames-3",   200, "/highscores/listgames");
		$this->addMethodMultiPathStatus("api::highscore::listentries-1", 200, "/highscores/list.php?gameid={0}", function(){ return [1,2,3,4,5,6]; });
		$this->addMethodMultiPathStatus("api::highscore::listentries-2", 200, "/highscores/list?gameid={0}", function(){ return [1,2,3,4,5,6]; });
		$this->addMethodMultiPathStatus("api::highscore::listentries-3", 200, "/highscores/listentries?gameid={0}", function(){ return [1,2,3,4,5,6]; });
		$this->addMethodMultiPathStatus("api::highscore::top50-1",       200, "/highscores/list_top50.php?gameid={0}", function(){ return [1,2,3,4,5,6]; });
		$this->addMethodMultiPathStatus("api::highscore::top50-2",       200, "/highscores/list_top50?gameid={0}", function(){ return [1,2,3,4,5,6]; });

		$this->addMethodGitStatusCheck("backend::git::git-status");
	}

	/** @noinspection PhpUnhandledExceptionInspection */
	public function listMethodGroups()
	{
		$data = [];
		foreach ($this->methods as $method)
		{
			$parts = explode('::', $method['name']);
			if (count($parts) !== 3) throw new Exception();

			$data []= ($parts[0] . '::' . $parts[1]);
		}
		$data = array_unique($data);

		$result = [];
		foreach ($data as $d)
		{
			$result []=
			[
				'name'   => key_exists($d, self::DISPLAY_NAMES) ? self::DISPLAY_NAMES[$d] : $d,
				'filter' => $d.'::*',
				'base'   => $d,
				'root'   => explode('::', $d)[0],
			];
		}

		sort($result);

		return $result;
	}

	private function addMethodPathStatus(string $name, int $status, string $path)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name, $path, $status)
			{
				$xname = explode('::', $name)[2];

				try
				{
					if (!Website::inst()->isProd()) return
					[
						'result' => self::STATUS_WARN,
						'message' => '{'.$xname.'} not executed: curl requests in dev mode prohibited',
						'long' => null,
						'exception' => null,
					];

					$url = 'https://' . $_SERVER['HTTP_HOST'] . $path;
					$r = curl_http_request($url);
					if ($r['statuscode'] === $status) return
					[
						'result' => self::STATUS_OK,
						'message' => "{".$xname."} succeeded",
						'long' => null,
						'exception' => null,
					];

					return
					[
						'result' => self::STATUS_ERROR,
						'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
						'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n" .
						          "URL: $url\n".
							      "Redirect: " . $r['redirect'] . "\n" .
							      "Response:\n" . $r['output'] . "\n".
							      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
						'exception' => null,
					];
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addMethodMultiPathStatus(string $name, int $status, string $path, Closure $supplier)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name, $path, $status, $supplier)
			{
				$xname = explode('::', $name)[2];

				try
				{
					if (!Website::inst()->isProd()) return
					[
						'result' => self::STATUS_WARN,
						'message' => '{'.$xname.'} not executed: curl requests in dev mode prohibited',
						'long' => null,
						'exception' => null,
					];

					$supdata = $supplier();

					$message = '';
					$count = 0;
					$i = 0;
					foreach ($supdata as $d)
					{
						$i++;
						$sxname = $xname . '-' . $i;

						$url = 'https://' . $_SERVER['HTTP_HOST'] . str_replace('{0}', $d, $path);
						$r = curl_http_request($url);
						$count++;
						if ($r['statuscode'] === $status) { $message .= "    {".$sxname."} succeeded" . "\n"; continue; }

						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$sxname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n".
								      "URL: $url\n".
								      "Redirect: " . $r['redirect'] . "\n" .
								      "Response:\n" . $r['output'] . "\n".
								      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}

					return
					[
						'result' => self::STATUS_OK,
						'message' => "$count requests succeeded\n" . trim($message, "\n"),
						'long' => null,
						'exception' => null,
					];
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addCheckConsistency(string $name, Closure $moduleSupplier)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name, $moduleSupplier)
			{
				try
				{
					/** @var IWebsiteModule $module */
					$module = $moduleSupplier();

					$consistency = $module->checkConsistency();

					if ($consistency['result'] === 'err') return
					[
						'result' => self::STATUS_ERROR,
						'message' => $consistency['message'],
						'long' => isset($consistency['long']) ? $consistency['long'] : null,
						'exception' => null,
					];

					if ($consistency['result'] === 'warn') return
					[
						'result' => self::STATUS_WARN,
						'message' => $consistency['message'],
						'long' => isset($consistency['long']) ? $consistency['long'] : null,
						'exception' => null,
					];

					if ($consistency['result'] === 'ok') return
					[
						'result' => self::STATUS_OK,
						'message' => 'OK',
						'long' => isset($consistency['long']) ? $consistency['long'] : null,
						'exception' => null,
					];

					throw new Exception("Unknown result: " . print_r($consistency, true));
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => str_max_len($e->getMessage(), 48),
						'long' => formatException($e),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addLambdaStatus(string $name, Closure $fun)
	{
		$this->methods []=
			[
				'name' => $name,
				'func' => function() use ($name, $fun)
				{
					try
					{
						$result = $fun();

						if (empty($result)) return
						[
							'result' => self::STATUS_OK,
							'message' => 'OK',
							'long' => 'Okay',
							'exception' => null,
						];

						if (isset($result['result']) && isset($result['message'])) {
							if ($result['result'] === 'err') return
							[
								'result' => self::STATUS_ERROR,
								'message' => $result['message'],
								'long' => isset($result['long']) ? $result['long'] : null,
								'exception' => null,
							];

							if ($result['result'] === 'warn') return
							[
								'result' => self::STATUS_WARN,
								'message' => $result['message'],
								'long' => isset($result['long']) ? $result['long'] : null,
								'exception' => null,
							];

							if ($result['result'] === 'ok') return
							[
								'result' => self::STATUS_OK,
								'message' => 'OK',
								'long' => isset($result['long']) ? $result['long'] : null,
								'exception' => null,
							];
						}

						if (is_array($result) && is_string($result[0])) {
							return
							[
								'result' => self::STATUS_ERROR,
								'message' => count($result) . " errors occured",
								'long' => implode("\n", $result),
								'exception' => null,
							];
						}

						throw new Exception("Unknown result: " . print_r($result, true));
					}
					catch (Throwable $e)
					{
						return
							[
								'result' => self::STATUS_ERROR,
								'message' => str_max_len($e->getMessage(), 48),
								'long' => formatException($e),
								'exception' => $e,
							];
					}
				}
			];
	}

	private function addMethodPathResponse(string $name, int $status, string $json_expected, string $path)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name, $path, $status, $json_expected)
			{
				$xname = explode('::', $name)[2];

				try
				{
					if (!Website::inst()->isProd()) return
					[
						'result' => self::STATUS_WARN,
						'message' => '{'.$xname.'} not executed: curl requests in dev mode prohibited',
						'long' => null,
						'exception' => null,
					];

					$url = 'https://' . $_SERVER['HTTP_HOST'] . $path;
					$r = curl_http_request($url);

					if ($r['statuscode'] !== $status)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n".
								      "URL: $url\n" .
								      "Response:\n" . $r['output'] . "\n".
								      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}

					$jj_found    = json_encode(json_decode($r['output']));
					$jj_expected = json_encode(json_decode($json_expected));

					if ($jj_found !== $jj_expected)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong response',
							'long' => "Wrong HTTP Response\n".
								      "Expected:\n$json_expected\n".
								      "Found:\n".$r['output'] . "\n".
								      "URL: $url\n" .
								      "HTTP Statuscode:\n" . $r['statuscode'] . "\n".
								      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}

					return
					[
						'result' => self::STATUS_OK,
						'message' => "{".$xname."} succeeded",
						'long' => null,
						'exception' => null,
					];
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addMethodGitStatusCheck(string $name)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name)
			{
				$xname = explode('::', $name)[2];

				try
				{
					if (!Website::inst()->isProd()) return
					[
						'result' => self::STATUS_WARN,
						'message' => '{'.$xname.'} not executed in dev mode',
						'long' => null,
						'exception' => null,
					];

					$r = Website::inst()->gitStatus();

					if (!$r)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => "{$xname} failed (command error)",
							'long' => $r,
							'exception' => null,
						];
					}

                    if (!$r[2])
                    {
                        return
                            [
                                'result' => self::STATUS_ERROR,
                                'message' => "{$xname} failed (git repo not clean)",
                                'long' => $r,
                                'exception' => null,
                            ];
                    }

                    if ($r[0] === false || $r[1] === false)
                    {
                        return
                            [
                                'result' => self::STATUS_ERROR,
                                'message' => "{$xname} failed (failed to query branch/sha)",
                                'long' => $r,
                                'exception' => null,
                            ];
                    }

					{
						return
						[
							'result' => self::STATUS_OK,
							'message' => "{".$xname."} succeeded ('$r[0]' | '$r[1]')",
							'long' => $r,
							'exception' => null,
						];
					}

				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addMethodExtProgLinks(string $name)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name)
			{
				$xname = explode('::', $name)[2];

				if (!Website::inst()->isProd()) return
				[
					'result' => self::STATUS_WARN,
					'message' => '{'.$xname.'} not executed: curl requests in dev mode prohibited',
					'long' => null,
					'exception' => null,
				];

				try
				{
					$message = '';
					$count = 0;
					foreach (Website::inst()->modules->Programs()->listAll() as $prog)
					{
						foreach ($prog['urls'] as $urlname => $urlobj)
						{
							$url = $urlobj;
							if (is_array($urlobj)) $url = $urlobj['url'];

                            if ($url     === 'direct')       continue;
                            if ($urlname === 'homebrew-tap') continue;

							$r = curl_http_request($url);
							$count++;
							if ($r['statuscode'] === 200 || $r['statuscode'] === 301 || $r['statuscode'] === 302) { $message .= "[".$prog['name']."] Request to '$url' succeeded" . "\n"; continue; }

							if ($r['statuscode'] === 403  && $urlname === 'alternativeto') { $message .= "[".$prog['name']."] Request to '$url' succeeded (alternative.to | 403)" . "\n"; continue; }

							return
							[
								'result' => self::STATUS_ERROR,
								'message' => '['.$prog['name'].'] failed: Request to returned wrong statuscode',
								'long' => 'Wrong HTTP Statuscode from "'.$url.'"' . "\n".
									      "Expected: [200|301|302]\n".
									      "Found: [".$r['statuscode'].']' . "\n" .
									      "Response:\n" . $r['output'] . "\n".
									      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
								'exception' => null,
							];
						}
					}

					return
					[
						'result' => self::STATUS_OK,
						'message' => "$count requests succeeded\n" . $message,
						'long' => null,
						'exception' => null,
					];
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	private function addHTTPSRedirect(string $name, string $path)
	{
		$this->methods []=
		[
			'name' => $name,
			'func' => function() use ($name, $path)
			{
				$xname = explode('::', $name)[2];

				try
				{
					if (!Website::inst()->isProd()) return
					[
						'result' => self::STATUS_WARN,
						'message' => '{'.$xname.'} not executed: curl requests in dev mode prohibited',
						'long' => null,
						'exception' => null,
					];

					$url1 = 'http://'  . $_SERVER['HTTP_HOST'] . $path;
					$url2 = 'https://' . $_SERVER['HTTP_HOST'] . $path;

					$r = curl_http_request($url1);
					if ($r['statuscode'] !== 301)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: [301]; Found: ['.$r['statuscode'].'])' . "\n".
								      "URL: $url1 >> $url2\n" .
								      "Response:\n" . $r['output'] . "\n" .
								      "Redirect:\n" . $r['redirect'] . "\n".
								      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}
					if (rtrim($r['redirect'], "/\t \n#") !== rtrim($url2, "/\t \n#"))
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong redirect',
							'long' => "Wrong Redirect URL\n" .
								      'Expected: "'.$url2.'"' . "\n" .
								      'Found: "'.$r['redirect'].'")' . "\n" .
								      "Response:\n" . $r['output'] . "\n" .
								      "Redirect:\n" . $r['redirect'] . "\n".
								      "Error [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}

					return
					[
						'result' => self::STATUS_OK,
						'message' => "{".$xname."} succeeded",
						'long' => null,
						'exception' => null,
					];
				}
				catch (Exception $e)
				{
					return
					[
						'result' => self::STATUS_ERROR,
						'message' => "{$xname} failed: " . $e->getMessage(),
						'long' => str_max_len($e->getMessage(), 48),
						'exception' => $e,
					];
				}
			}
		];
	}

	public function run($filter)
	{
		$rex = '/^' . str_replace('*', '([^:]*)', $filter) . '$/';

		$fullmessage = '';
		$fullwarnmessage = '';

		$warnings = 0;
		$count = 0;
		foreach ($this->methods as $method)
		{
			if (!preg_match($rex, $method['name'])) continue;

			$r = $method['func']();
			if ($r['result'] === self::STATUS_ERROR) return $r;
			if ($r['result'] === self::STATUS_WARN) { $warnings++; $fullwarnmessage .= $r['message'] . "\n"; }
			$fullmessage .= $r['message'] . "\n";

			$count++;
		}

		if ($warnings > 0)
		{
			return
			[
				'result' => self::STATUS_WARN,
				'message' => "$warnings/$count methods had warnings",
				'long' => $fullwarnmessage,
				'exception' => null,
			];
		}

		if ($count === 0) return
		[
			'result' => self::STATUS_WARN,
			'message' => "No methods matched filter",
			'long' => null,
			'exception' => null,
		];

		return
		[
			'result' => self::STATUS_OK,
			'message' => "OK",
			'long' => "$count methods succeeded\n\n" . $fullmessage,
			'exception' => null,
		];
	}

	public function checkConsistency()
	{
		return ['result'=>'ok', 'message' => ''];
	}
}
