<?php

require_once (__DIR__ . '/internals/base.php');

$URL_RULES =
[
	[ 'url' => [],                                           'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['index'],                                    'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['index.php'],                                'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['msmain', 'index'],                          'target' => 'pages/main.php',                   'options' => [],                                        ],
	[ 'url' => ['about'],                                    'target' => 'pages/about.php',                  'options' => [],                                        ],
	[ 'url' => ['msmain', 'about'],                          'target' => 'pages/about.php',                  'options' => [],                                        ],
	
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
	
	[ 'url' => ['update.php'],                               'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%GET%' ],                     ],
	[ 'url' => ['update.php', '?{Name}'],                    'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%URL%' ],                     ],
	[ 'url' => ['update'],                                   'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%GET%' ],                     ],
	[ 'url' => ['update', '?{Name}'],                        'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%URL%' ],                     ],
	[ 'url' => ['update2'],                                  'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%GET%' ],                     ],
	[ 'url' => ['api', 'update'],                            'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%GET%' ],                     ],
	[ 'url' => ['api', 'update', '?{Name}'],                 'target' => 'pages/api_updatecheck.php',        'options' => [ 'Name' => '%URL%' ],                     ],
	[ 'url' => ['api', 'test'],                              'target' => 'pages/api_test.php',               'options' => [],                                        ],
	[ 'url' => ['api', 'setselfadress'],                     'target' => 'pages/api_setselfadress.php',      'options' => [],                                        ],
	
	[ 'url' => ['msmain', 'admin', 'egh', '?{commandcode}'], 'target' => 'pages/admin_egh.php',              'options' => [ 'commandcode' => '%URL%' ],              ],
	[ 'url' => ['msmain', 'adminEGH'],                       'target' => 'pages/admin_egh.php',              'options' => [ 'commandcode' => '%GET%' ],              ],
	
	[ 'url' => ['blog'],                                     'target' => 'pages/blog_list.php',              'options' => [],                                        ],
	[ 'url' => ['blogpost', 'index'],                        'target' => 'pages/blog_list.php',              'options' => [],                                        ],
	[ 'url' => ['blog', '?{id}'],                            'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}'],                            'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}', '?{name}'],                 'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '' ],      ],
	[ 'url' => ['blog', '?{id}', '?{name}', '?{subview}'],   'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%URL%', 'subview' => '%URL%' ], ],
	[ 'url' => ['blogpost', 'view'],                         'target' => 'pages/blog_view.php',              'options' => [ 'id' => '%GET%', 'subview' => '' ],      ],
	
	[ 'url' => ['highscores', 'list.php'],                   'target' => 'pages/highscores_listentries.php', 'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'list'],                       'target' => 'pages/highscores_listentries.php', 'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'listentries'],                'target' => 'pages/highscores_listentries.php', 'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'list.php'],                   'target' => 'pages/highscores_listgames.php',   'options' => [],                                        ],
	[ 'url' => ['highscores', 'list'],                       'target' => 'pages/highscores_listgames.php',   'options' => [],                                        ],
	[ 'url' => ['highscores', 'listgames'],                  'target' => 'pages/highscores_listgames.php',   'options' => [],                                        ],
	[ 'url' => ['highscores', 'insert.php'],                 'target' => 'pages/highscores_insert.php',      'options' => [ 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%' ], ],
	[ 'url' => ['highscores', 'insert'],                     'target' => 'pages/highscores_insert.php',      'options' => [ 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%' ], ],
	[ 'url' => ['highscores', 'update.php'],                 'target' => 'pages/highscores_update.php',      'options' => [ 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%', 'nameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'update'],                     'target' => 'pages/highscores_update.php',      'options' => [ 'gameid' => '%GET%', 'check' => '%GET%', 'name' => '%GET%', 'rand' => '%GET%', 'points' => '%GET%', 'nameid' => '%GET%' ], ],
	[ 'url' => ['highscores', 'list_top50.php'],             'target' => 'pages/highscores_top50.php',       'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'list_top50'],                 'target' => 'pages/highscores_top50.php',       'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'getNewID.php'],               'target' => 'pages/highscores_newid.php',       'options' => [ 'gameid' => '%GET%' ],                   ],
	[ 'url' => ['highscores', 'newid'],                      'target' => 'pages/highscores_newid.php',       'options' => [ 'gameid' => '%GET%' ],                   ],
	
	[ 'url' => ['404'],                                      'target' => 'pages/error_404.php',              'options' => [],                                        ],
];

//#############################################################################

$path      = strtolower(parse_url($_SERVER['REQUEST_URI'])['path']);
$pathparts = preg_split('@/@', $path, NULL, PREG_SPLIT_NO_EMPTY);
$partcount = count($pathparts);

global $OPTIONS;

foreach ($URL_RULES as $rule)
{
	if ($partcount !== count($rule['url'])) continue;
	
	$urlparams = [];
	
	$match = true;
	for($i = 0; $i < $partcount; $i++)
	{
		$comp = $rule['url'][$i];
		if (startsWith($comp, '?{') && endsWith($comp, '}'))
		{
			$ident = substr($comp, 2, strlen($comp)-3);
			$urlparams[$ident] = $pathparts[$i];
		}
		else
		{
			if (strtolower($comp) !== strtolower($pathparts[$i])) { $match = false; break; }
		}
	}
	if (!$match) continue;
	
	$opt = [];
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
			$value = $urlparams[$optname];
		}
		
		$opt[strtolower($optname)] = $value;
	}
	if (!$match) continue;
	
	$OPTIONS = $opt;
	include $rule['target'];
	return;
	
}

{
	// [404] - Page Not Found
	$OPTIONS = [];
	include 'pages/error_404.php';
	return;
}
