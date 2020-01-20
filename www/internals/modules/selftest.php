<?php

class SelfTest implements IWebsiteModule
{
	private const STATUS_ERROR = 2;
	private const STATUS_WARN  = 1;
	private const STATUS_OK    = 0;

	private const DISPLAY_NAMES =
	[
		'web::main'             => 'Website (http)',
		'web::programs'         => 'Programs (http)',
		'web::books'            => 'Books (http)',
		'web::blog'             => 'Blog (http)',
		'web::webapps'          => 'WebApps (http)',
		'web::euler'            => 'Project Euler (http)',
		'web::aoc'              => 'Advent of Code (http)',
		'api::default'          => 'API',
		'api::highscore'        => 'Highscores API',
		'modules::database'     => 'Database',
		'modules::blog'         => 'Blog (data)',
		'modules::euler'        => 'Project Euler (data)',
		'modules::books'        => 'Books (data)',
		'modules::extgitgraph'  => 'ExtendedGitGraph (data)',
		'modules::programs'     => 'Programs (data)',
		'modules::adventofcode' => 'Advent of Code (data)',
		'modules::anstatistics' => 'AlephNote Stats (data)',
		'modules::updateslog'   => 'Program Updates (data)',
		'modules::webapps'      => 'Webapps (data)',
		'modules::highscores'   => 'Highscores (data)',
		'backend::git'          => 'Git Repository'
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
		$this->addHTTPSRedirect(  "web::main::redirect-1", '');
		$this->addHTTPSRedirect(  "web::main::redirect-2", '/about');
		$this->addHTTPSRedirect(   "web::main::redirect-3", '/about');

		$this->addMethodPathStatus(     "web::programs::programs-list-1",     200, '/programs');
		$this->addMethodPathStatus(     "web::programs::programs-list-2",     200, '/programs/index');
		$this->addMethodPathStatus(     "web::programs::programs-list-3",     200, '/downloads/details.php');
		$this->addMethodPathStatus(     "web::programs::programs-list-4",     200, '/downloads/downloads.php');
		$this->addMethodMultiPathStatus("web::programs::programs-filtered-1", 200, '/programs/index?categoryfilter={0}', function(){ return array_key_map_unique(Website::inst()->modules->Programs()->listAll(), 'category'); });
		$this->addMethodMultiPathStatus("web::programs::programs-filtered-2", 200, '/programs/cat/{0}', function(){ return array_key_map_unique(Website::inst()->modules->Programs()->listAll(), 'category'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-1",     200, '/programs/view/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-2",     200, '/programs/view?id={0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-show-3",     200, '{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'url'); });
		$this->addMethodMultiPathStatus("web::programs::programs-download-1", 301, '/downloads/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-download-2", 301, '/programs/download/{0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodMultiPathStatus("web::programs::programs-download-3", 301, '/programs/download?id={0}', function(){ return array_key_map(Website::inst()->modules->Programs()->listAll(), 'internal_name'); });
		$this->addMethodPathStatus(     "web::programs::programs-404-1",      404, '/programs/view/asdf_not_found');
		$this->addMethodPathStatus(     "web::programs::programs-404-2",      404, '/programs/download/asdf_not_found');
		$this->addMethodExtProgLinks(   "web::programs::programs-ext-links");

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

		$this->addMethodMultiPathStatus("web::aoc::aoc-list-1", 200, '{0}', function(){ return array_map(function($x){return Website::inst()->modules->AdventOfCode()->getURLForYear($x);},Website::inst()->modules->AdventOfCode()->listYears()); });
		$this->addMethodMultiPathStatus("web::aoc::aoc-show-1", 200, '{0}', function(){ return array_key_map(Website::inst()->modules->AdventOfCode()->listAllDays(), 'url'); });
		$this->addMethodPathStatus(     "web::aoc::aoc-404-1",  404, '/blog/25/Advent_of_Code_2017/day-26');
		$this->addMethodPathStatus(     "web::aoc::aoc-404-2",  404, '/blog/23/Advent_of_Code_2018/day-27');
		$this->addMethodPathStatus(     "web::aoc::aoc-404-3",  404, '/blog/24/Advent_of_Code_2019/day-28');

		$this->addCheckConsistency("modules::database::database-check-consistency",         function(){ return Website::inst()->modules->Database(); });
		$this->addCheckConsistency("modules::blog::blog-check-consistency",                 function(){ return Website::inst()->modules->Blog(); });
		$this->addCheckConsistency("modules::euler::euler-check-consistency",               function(){ return Website::inst()->modules->Euler(); });
		$this->addCheckConsistency("modules::books::books-check-consistency",               function(){ return Website::inst()->modules->Books(); });
		$this->addCheckConsistency("modules::extgitgraph::extgitgraph-check-consistency",   function(){ return Website::inst()->modules->ExtendedGitGraph(); });
		$this->addCheckConsistency("modules::programs::programs-check-consistency",         function(){ return Website::inst()->modules->Programs(); });
		$this->addCheckConsistency("modules::books::books-check-consistency",               function(){ return Website::inst()->modules->Books(); });
		$this->addCheckConsistency("modules::adventofcode::adventofcode-check-consistency", function(){ return Website::inst()->modules->AdventOfCode(); });
		$this->addCheckConsistency("modules::anstatistics::anstatistics-check-consistency", function(){ return Website::inst()->modules->AlephNoteStatistics(); });
		$this->addCheckConsistency("modules::updateslog::updateslog-check-consistency",     function(){ return Website::inst()->modules->UpdatesLog(); });
		$this->addCheckConsistency("modules::webapps::webapps-check-consistency",           function(){ return Website::inst()->modules->WebApps(); });
		$this->addCheckConsistency("modules::highscores::highscores-check-consistency",     function(){ return Website::inst()->modules->Highscores(); });

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
		$this->addMethodPathStatus(     "api::default::egg-status",    200, "/api/extendedgitgraph::status?ajax_secret=$ajaxsecret");
		$this->addMethodPathStatus(     "api::default::an-show",       200, "/api/alephnote::show?ajax_secret=$ajaxsecret");
		$this->addMethodPathStatus(     "api::default::updates-show",  200, "/api/updates::show?ajax_secret=$ajaxsecret");
		$this->addMethodPathStatus(     "api::default::aoc-ajax",      200, "/api/html::panel_aoc_calendar");
		$this->addMethodPathStatus(     "api::default::404-1",         404, '/api/update/no_prog_xx');
		$this->addMethodPathStatus(     "api::default::404-2",         404, '/api/asdf::notfound');

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
				'base'   => $d
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

					$r = curl_http_request($_SERVER['HTTP_HOST'] . $path);
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
						'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n" . "Response:\n" . $r['output'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
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
					foreach ($supdata as $d)
					{
						$r = curl_http_request($_SERVER['HTTP_HOST'] . str_replace('{0}', $d, $path));
						$count++;
						if ($r['statuscode'] === $status) { $message .= "{".$xname."} succeeded" . "\n"; continue; }

						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n" . "Response:\n" . $r['output'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
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

					$r = curl_http_request($_SERVER['HTTP_HOST'] . $path);
					if ($r['statuscode'] !== $status)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: ['.$status.']; Found: ['.$r['statuscode'].'])' . "\n" . "Response:\n" . $r['output'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}
					if (json_encode(json_decode($r['output'])) == json_encode(json_decode($json_expected)))
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => "Wrong HTTP Response\nExpected:\n$json_expected\nFound:\n".$r['output'] . "\n" . "HTTP Statuscode:\n" . $r['statuscode'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
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

					$r = exec('git rev-parse --abbrev-ref HEAD');
					$ok = (strpos($r, 'Your branch is up to date with') !== false) && (strpos($r, 'nothing to commit, working tree clean') !== false);

					if (!$ok)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => "{$xname} failed",
							'long' => $r,
							'exception' => null,
						];
					}
					else
					{
						return
						[
							'result' => self::STATUS_OK,
							'message' => "{".$xname."} succeeded",
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
						foreach ($prog['urls'] as $urlobj)
						{
							$url = $urlobj;
							if (is_array($urlobj)) $url = $urlobj['url'];

							$r = curl_http_request($url);
							$count++;
							if ($r['statuscode'] === 200) { $message .= "[".$prog['name']."] Request to '$url' succeeded" . "\n"; continue; }

							return
							[
								'result' => self::STATUS_ERROR,
								'message' => '['.$prog['name'].'] failed: Request to returned wrong statuscode',
								'long' => 'Wrong HTTP Statuscode from "'.$url.'"' . "\nExpected: [200]\nFound: [".$r['statuscode'].']' . "\n" . "Response:\n" . $r['output'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
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

					$host = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);
					$port = parse_url($_SERVER['HTTP_HOST'], PHP_URL_PORT);

					$url1 = 'http://'  . $host . ':' . $port . $path;
					$url2 = 'https://' . $host . ':' . $port . $path;

					$r = curl_http_request($url1);
					if ($r['statuscode'] !== 310)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong statuscode',
							'long' => 'Wrong HTTP Statuscode (Expected: [200]; Found: ['.$r['statuscode'].'])' . "\n" . "Response:\n" . $r['output'] . "\n" . "Redirect:\n" . $r['redirect'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
							'exception' => null,
						];
					}
					if ($r['redirect'] !== $url2)
					{
						return
						[
							'result' => self::STATUS_ERROR,
							'message' => '{'.$xname.'} failed: Request returned wrong redirect',
							'long' => 'Wrong Redirect URL (Expected: ['.$url2.']; Found: ['.$r['redirect'].'])' . "\n" . "Response:\n" . $r['output'] . "\n" . "Redirect:\n" . $r['redirect'] . "\nError [" . $r['errnum'] . "]:\n" . $r['errstr'],
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