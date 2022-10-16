<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';


$API_COMMANDS =
[
	'base::test'                    => [ 'src' => __DIR__.'/../commands/base_test.php',                    'auth' => 'none'           ],

	'progs::updatecheck'            => [ 'src' => __DIR__.'/../commands/progs_updatecheck.php',            'auth' => 'none'           ],

	'site::createprogramthumbnails' => [ 'src' => __DIR__.'/../commands/site_createProgramThumbnails.php', 'auth' => 'admin'          ],
	'site::createbookthumbnails'    => [ 'src' => __DIR__.'/../commands/site_createBookThumbnails.php',    'auth' => 'admin'          ],
	'site::selftest'                => [ 'src' => __DIR__.'/../commands/site_selftest.php',                'auth' => 'admin'          ],
	'site::gitinfo'                 => [ 'src' => __DIR__.'/../commands/site_gitinfo.php',                 'auth' => 'admin'          ],

	'server::setselfaddress'        => [ 'src' => __DIR__.'/../commands/server_setselfaddress.php',        'auth' => 'none'           ],
	'server::gitwebhook'            => [ 'src' => __DIR__.'/../commands/server_gitwebhook.php',            'auth' => 'webhook_secret' ],
	'server::backupupload'          => [ 'src' => __DIR__.'/../commands/server_backupupload.php',          'auth' => 'upload_secret'  ],

	'extendedgitgraph::status'      => [ 'src' => __DIR__.'/../commands/extendedgitgraph_status.php',      'auth' => 'ajax_secret'    ],
	'extendedgitgraph::redraw'      => [ 'src' => __DIR__.'/../commands/extendedgitgraph_redraw.php',      'auth' => 'ajax_secret'    ],
	'extendedgitgraph::refresh'     => [ 'src' => __DIR__.'/../commands/extendedgitgraph_refresh.php',     'auth' => 'ajax_secret'    ],

	'alephnote::statsping'          => [ 'src' => __DIR__.'/../commands/alephnote_statsping.php',          'auth' => 'none'           ],
	'alephnote::show'               => [ 'src' => __DIR__.'/../commands/alephnote_show.php',               'auth' => 'ajax_secret'    ],

	'updates::show'                 => [ 'src' => __DIR__.'/../commands/updates_show.php',                 'auth' => 'ajax_secret'    ],

	'html::panel_aoc_calendar'      => [ 'src' => __DIR__.'/../commands/html_panel-aoc-calendar.php',      'auth' => 'none'           ],
];

$cmd = strtolower($ROUTE->parameter['cmd']);

if (!array_key_exists($cmd, $API_COMMANDS))
{
	ob_clean();
	print("<div style=\"white-space: pre;font-family: monospace;\">\n");
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
	print("</div>\n");
	print("Wrong command.");
	$reaper = ob_get_clean();

	$FRAME_OPTIONS->forceResult(404, $reaper);
	return;
}

$config = $API_COMMANDS[$cmd];


$secret = isset($_GET['secret']) ? $_GET['secret'] : '';

if ($config['auth'] === 'webhook_secret' && $secret !== $SITE->config['webhook_secret']) { $FRAME_OPTIONS->forceResult(401, "Unauthorized."); return; }
if ($config['auth'] === 'ajax_secret'    && $secret !== $SITE->config['ajax_secret'])    { $FRAME_OPTIONS->forceResult(401, "Unauthorized."); return; }
if ($config['auth'] === 'upload_secret'  && $secret !== $SITE->config['upload_secret'])  { $FRAME_OPTIONS->forceResult(401, "Unauthorized."); return; }
if ($config['auth'] === 'admin'          && !$SITE->isLoggedInByCookie())                { $FRAME_OPTIONS->forceResult(401, "Unauthorized."); return; }


global $API_OPTIONS;

$API_OPTIONS = [];
foreach ($_GET as $k => $v) $API_OPTIONS[strtolower($k)] = $v;
foreach ($ROUTE->urlParameter as $k => $v) $API_OPTIONS[strtolower($k)] = $v;

try
{
	/** @noinspection PhpIncludeInspection */
	include $config['src'];
}
catch (exception $e)
{
	$content =
		"REQUEST: " . var_export($_REQUEST) . "\n\n" .
		"IP:      " . get_client_ip()       . "\n\n" .
		"ERROR:   " . $e                    . "\n\n";

	if ($SITE->isProd()) sendMail("Website API call failed", $content, 'virtualadmin@mikescher.de', 'webserver-info@mikescher.com');

	$msg = "Error.";
	if (!$SITE->isProd()) $msg = "Error.\n" . "API Command failed with exception.\n" . $e;

	$FRAME_OPTIONS->forceResult(500, $msg);
	return;
}
