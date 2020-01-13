<?php

require_once (__DIR__ . '/internals/website.php');

$site = new Website();
$site->init();

$URL_RULES =
[
	[ 'url' => [],                                           'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['index'],                                    'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['index.php'],                                'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['msmain', 'index'],                          'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['about'],                                    'target' => 'pages/about.php',                  'options' => [],                                        ],
	[ 'url' => ['msmain', 'about'],                          'target' => 'pages/about.php',                  'options' => [],                                        ],
	[ 'url' => ['login'],                                    'target' => 'pages/login.php',                  'options' => [ 'login_target'  => '/' ],                ],
	[ 'url' => ['logout'],                                   'target' => 'pages/logout.php',                 'options' => [ 'logout_target' => '/' ],                ],

	[ 'url' => ['programs'],                                 'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '' ],                ],
	[ 'url' => ['programs', 'index'],                        'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '%GET%' ],           ],
	[ 'url' => ['programs', 'index'],                        'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '' ],                ],
	[ 'url' => ['programs', 'cat', '?{categoryfilter}'],     'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '%URL%' ],           ],
	[ 'url' => ['downloads', 'details.php'],                 'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '' ],                ],
	[ 'url' => ['downloads', 'downloads.php'],               'target' => 'pages/programs_list.php',          'options' => [ 'categoryfilter' => '' ],                ],
	[ 'url' => ['programs', 'view', '?{id}'],                'target' => 'pages/programs_view.php',          'options' => [ 'id' => '%URL%' ],                       ],
	[ 'url' => ['programs', 'view'],                         'target' => 'pages/programs_view.php',          'options' => [ 'id' => '%GET%' ],                       ],
	[ 'url' => ['downloads', '?{id}'],                       'target' => 'pages/programs_download.php',      'options' => [ 'id' => '%URL%' ],                       ],
	[ 'url' => ['programs', 'download', '?{id}'],            'target' => 'pages/programs_download.php',      'options' => [ 'id' => '%URL%' ],                       ],
	[ 'url' => ['programs', 'download'],                     'target' => 'pages/programs_download.php',      'options' => [ 'id' => '%GET%' ],                       ],

	[ 'url' => ['books'],                                    'target' => 'pages/books_list.php',             'options' => [],                                        ],
	[ 'url' => ['books', 'list'],                            'target' => 'pages/books_list.php',             'options' => [],                                        ],
	[ 'url' => ['books', 'view', '?{id}'],                   'target' => 'pages/books_view.php',             'options' => [ 'id' => '%GET%' ],                       ],
	[ 'url' => ['books', 'view', '?{id}', '*'],              'target' => 'pages/books_view.php',             'options' => [ 'id' => '%URL%' ],                       ],

	[ 'url' => ['update.php'],                               'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['update.php', '?{Name}'],                    'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['update'],                                   'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['update', '?{Name}'],                        'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['update2'],                                  'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['api', 'update'],                            'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['api', 'update', '?{Name}'],                 'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'progs::updatecheck' ],            ],
	[ 'url' => ['api', 'test'],                              'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'base::test' ],                    ],
	[ 'url' => ['api', 'setselfadress'],                     'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'server::setselfaddress' ],        ],
	[ 'url' => ['api', 'statsping'],                         'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'alephnote::statsping' ],          ],
	[ 'url' => ['api', 'webhook', '?{target}'],              'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'server::gitwebhook' ],            ],
	[ 'url' => ['api', 'backupupload'],                      'target' => 'pages/api.php',                    'options' => [ '_opt' => 'http',     'cmd' => 'server::backupupload' ],          ],
	[ 'url' => ['api', '?{cmd}'],                            'target' => 'pages/api.php',                    'options' => [                       'cmd' => '%URL%' ],                         ],

	[ 'url' => ['admin'],                                    'target' => 'pages/admin.php',                  'options' => [ '_opt' => 'password'],                   ],

	[ 'url' => ['blog'],                                     'target' => 'pages/blog_list.php',              'options' => [],                                        ],
	[ 'url' => ['log'],                                      'target' => 'pages/blog_list.php',              'options' => [],                                        ],
	[ 'url' => ['blogpost', 'index'],                        'target' => 'pages/blog_list.php',              'options' => [],                                        ],
	[ 'url' => ['blog', '?{id}'],                            'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}'],                            'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}', '?{name}'],                 'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}', '?{name}', '?{subview}'],   'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '%URL%' ], ],
	[ 'url' => ['log', '?{id}'],                             'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['log', '?{id}'],                             'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['log', '?{id}', '?{name}'],                  'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['log', '?{id}', '?{name}', '?{subview}'],    'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '%URL%' ], ],
	[ 'url' => ['blogpost', 'view'],                         'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%GET%', 'subview' => '' ],      ],

	[ 'url' => ['webapps'],                                  'target' => 'pages/webapps_list.php',           'options' => [],                                        ],

	[ 'url' => ['highscores', 'list.php'],                   'target' => 'pages/highscores_listentries.php', 'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'list'],                       'target' => 'pages/highscores_listentries.php', 'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'listentries'],                'target' => 'pages/highscores_listentries.php', 'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'list.php'],                   'target' => 'pages/highscores_listgames.php',   'options' => [ '_opt' => 'http' ],                      ],
	[ 'url' => ['highscores', 'list'],                       'target' => 'pages/highscores_listgames.php',   'options' => [ '_opt' => 'http' ],                      ],
	[ 'url' => ['highscores', 'listgames'],                  'target' => 'pages/highscores_listgames.php',   'options' => [ '_opt' => 'http' ],                      ],
	[ 'url' => ['highscores', 'insert.php'],                 'target' => 'pages/highscores_insert.php',      'options' => [ '_opt' => 'http', 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%' ], ],
	[ 'url' => ['highscores', 'insert'],                     'target' => 'pages/highscores_insert.php',      'options' => [ '_opt' => 'http', 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%' ], ],
	[ 'url' => ['highscores', 'update.php'],                 'target' => 'pages/highscores_update.php',      'options' => [ '_opt' => 'http', 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%', 'nameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'update'],                     'target' => 'pages/highscores_update.php',      'options' => [ '_opt' => 'http', 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%', 'nameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'list_top50.php'],             'target' => 'pages/highscores_top50.php',       'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'list_top50'],                 'target' => 'pages/highscores_top50.php',       'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'getNewID.php'],               'target' => 'pages/highscores_newid.php',       'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'newid'],                      'target' => 'pages/highscores_newid.php',       'options' => [ '_opt' => 'http', 'gameid' => '%GET%' ], ],

	[ 'url' => ['404'],                                      'target' => 'pages/error_404.php',              'options' => [],                                        ],
];

$site->serve($URL_RULES);

//#############################################################################

try {
	InitPHP();

	if (isProd())
		$requri = $_SERVER['REQUEST_URI'];
	else
		$requri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'localhost:80/';

	$parse = parse_url($requri);

	$path      = isset($parse['path']) ? $parse['path'] : '';
	$pathparts = preg_split('@/@', $path, NULL, PREG_SPLIT_NO_EMPTY);
	$partcount = count($pathparts);

	global $OPTIONS;
	global $HEADER_ACTIVE;

	$HEADER_ACTIVE = 'none';

	foreach ($URL_RULES as $rule)
	{
		if ($partcount !== count($rule['url'])) continue;

		$urlparams = [];
		$ctrlOpt   = key_exists('_opt', $rule['options']) ? explode('|', $rule['options']['_opt']) : [];
		$target    = $rule['target'];

		$match = true;
		for($i = 0; $i < $partcount; $i++)
		{
			$comp = $rule['url'][$i];
			if (startsWith($comp, '?{') && endsWith($comp, '}'))
			{
				$ident = substr($comp, 2, strlen($comp)-3);
				$urlparams[$ident] = $pathparts[$i];
			}
			else if ($comp === '*')
			{
				// ok
			}
			else
			{
				if (strtolower($comp) !== strtolower($pathparts[$i])) { $match = false; break; }
			}
		}
		if (!$match) continue;

		$opt = [ 'controllerOptions' => $ctrlOpt, 'uri' => $requri ];
		foreach($rule['options'] as $optname => $optvalue)
		{
			$value = $optvalue;

			if ($value === '%GET%')
			{
				if (!isset($_GET[$optname])) { $match = false; break; }
				$value = $_GET[$optname];
			}
			else if ($value === '%POST%')
			{
				if (!isset($_POST[$optname])) { $match = false; break; }
				$value = $_POST[$optname];
			}
			else if ($value === '%URL%')
			{
				if (!isset($urlparams[$optname])) { $match = false; break; }
				$value = urldecode($urlparams[$optname]);
			}

			$opt[strtolower($optname)] = $value;
		}

		$opt['_urlparams'] = [];
		foreach ($urlparams as $name => $value) $opt['_urlparams'][strtolower($name)] = urldecode($value);

		if (!$match) continue;

		if (in_array('disabled', $ctrlOpt)) continue;

		if (in_array('password', $ctrlOpt))
		{
			if (!isLoggedInByCookie())
			{
				$opt['login_target'] = $path;
				$target = 'pages/login.php';
			}
		}

		$is_http = (!isset($_SERVER['HTTPS'])) || empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off";

		if (isProd() && $is_http && !in_array('http', $ctrlOpt))
		{
			ob_clean();
			$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $redirect);
			exit();
		}

		$OPTIONS = $opt;

		/** @noinspection PhpIncludeInspection */
		include $target;
		return;

	}

	{
		// [404] - Page Not Found
		$OPTIONS = [];
		httpError('404', 'Page not found');
		return;
	}

} catch (Exception $e) {

	if (isProd())
	{
		sendExceptionMail($e);
		httpError('500 ', 'Internal server error');
	}
	else
	{
		if (isset($e->xdebug_message)) echo '<table class="xdebug-error xe-uncaught-exception" dir="ltr" border="1" cellspacing="0" cellpadding="1">'.$e->xdebug_message.'</table>';
		else echo nl2br($e);
	}

}

//TODO euler insert+show 32bit | 64bit mode
//TODO support for different color schemes
//     should be possible to change with just a few constant in config.scss
//     a (little) bit more hue in default scheme
