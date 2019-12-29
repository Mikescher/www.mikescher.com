<?php

global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');

$API_COMMANDS =
[
	'base::test'                    => [ 'src' => __DIR__.'/../commands/base_test.php',                    'auth' => 'none'           ],

	'progs::updatecheck'            => [ 'src' => __DIR__.'/../commands/progs_updatecheck.php',            'auth' => 'none'           ],

	'site::createprogramthumbnails' => [ 'src' => __DIR__.'/../commands/site_createProgramThumbnails.php', 'auth' => 'admin'          ],
	'site::createbookthumbnails'    => [ 'src' => __DIR__.'/../commands/site_createBookThumbnails.php',    'auth' => 'admin'          ],

	'server::setselfaddress'        => [ 'src' => __DIR__.'/../commands/server_setselfaddress.php',        'auth' => 'none'           ],
	'server::gitwebhook'            => [ 'src' => __DIR__.'/../commands/server_gitwebhook.php',            'auth' => 'webhook_secret' ],
	'server::backupupload'          => [ 'src' => __DIR__.'/../commands/server_backupupload.php',          'auth' => 'upload_secret'  ],

	'extendedgitgraph::status'      => [ 'src' => __DIR__.'/../commands/extendedgitgraph_status.php',      'auth' => 'ajax_secret'    ],
	'extendedgitgraph::redraw'      => [ 'src' => __DIR__.'/../commands/extendedgitgraph_redraw.php',      'auth' => 'ajax_secret'    ],
	'extendedgitgraph::refresh'     => [ 'src' => __DIR__.'/../commands/extendedgitgraph_refresh.php',     'auth' => 'ajax_secret'    ],

	'alephnote::statsping'          => [ 'src' => __DIR__.'/../commands/alephnote_statsping.php',          'auth' => 'none'           ],
	'alephnote::show'               => [ 'src' => __DIR__.'/../commands/alephnote_show.php',               'auth' => 'ajax_secret'    ],

	'updates::show'                 => [ 'src' => __DIR__.'/../commands/updates_show.php',                 'auth' => 'ajax_secret'    ],
];

$cmd = strtolower($OPTIONS['cmd']);

if (!array_key_exists($cmd, $API_COMMANDS))
{
	print("                                                    \n");
	print("                                                    \n");
	print("                 ...                                \n");
	print("               ;::::;                               \n");
	print("             ;::::; :;                              \n");
	print("           ;:::::'   :;                             \n");
	print("          ;:::::;     ;.                            \n");
	print("         ,:::::'       ;           OOO\\             \n");
	print("         ::::::;       ;          OOOOO\\            \n");
	print("         ;:::::;       ;         OOOOOOOO           \n");
	print("        ,;::::::;     ;'         / OOOOOOO          \n");
	print("      ;:::::::::`. ,,,;.        /  / DOOOOOO        \n");
	print("    .';:::::::::::::::::;,     /  /     DOOOO       \n");
	print("   ,::::::;::::::;;;;::::;,   /  /        DOOO      \n");
	print("  ;`::::::`'::::::;;;::::: ,#/  /          DOOO     \n");
	print("  :`:::::::`;::::::;;::: ;::#  /            DOOO    \n");
	print("  ::`:::::::`;:::::::: ;::::# /              DOO    \n");
	print("  `:`:::::::`;:::::: ;::::::#/               DOO    \n");
	print("   :::`:::::::`;; ;:::::::::##                OO    \n");
	print("   ::::`:::::::`;::::::::;:::#                OO    \n");
	print("   `:::::`::::::::::::;'`:;::#                O     \n");
	print("    `:::::`::::::::;' /  / `:#                      \n");
	print("     ::::::`:::::;'  /  /   `#                      \n");
	print("                                                    \n");
	print("                                                    \n");
	httpDie(400, 'Wrong command.');
}

$config = $API_COMMANDS[$cmd];


$secret = isset($_GET['secret']) ? $_GET['secret'] : '';

if ($config['auth'] === 'webhook_secret' && $secret !== $CONFIG['webhook_secret']) httpDie(401, 'Unauthorized.');
if ($config['auth'] === 'ajax_secret'    && $secret !== $CONFIG['ajax_secret'])    httpDie(401, 'Unauthorized.');
if ($config['auth'] === 'upload_secret'  && $secret !== $CONFIG['upload_secret'])  httpDie(401, 'Unauthorized.');
if ($config['auth'] === 'admin'          && !isLoggedInByCookie())                 httpDie(401, 'Unauthorized.');


global $API_OPTIONS;

$API_OPTIONS = [];
foreach ($_GET as $k => $v) $API_OPTIONS[strtolower($k)] = $v;
foreach ($OPTIONS['_urlparams'] as $k => $v) $API_OPTIONS[strtolower($k)] = $v;

try
{
	/** @noinspection PhpIncludeInspection */
	include $config['src'];
}
catch (exception $e)
{
	print("API Command failed with exception");
	print($e);

	$content =
		"REQUEST: " . var_export($_REQUEST) . "\r\n\r\n" .
		"IP:      " . get_client_ip()       . "\r\n\r\n" .
		"ERROR:   " . $e                    . "\r\n\r\n";

	sendMail("Website API call failed", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

	httpDie(500, 'Error.');
}
