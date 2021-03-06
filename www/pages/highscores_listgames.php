<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';

$games = $SITE->modules->Highscores()->getAllGames();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<title>highscores</title>
	<style type="text/css">
		<!--
		body {
			background-color: #DDF;
			padding: 1em 1em 0em;
		}

		a {
			color: #008;
			text-decoration: underline;
		}

		a:hover { text-decoration: none; }
		-->
	</style>
</head>
<body>

<?php
	foreach ($games as $game)
	{
		echo '<a href="/Highscores/list?gameid=' . $game['ID'] . '">' . $game['NAME'] . '</a><br>' . "\r\n";
	}
?>

</body>
</html>