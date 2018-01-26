<?php
	global $OPTIONS;
	
	require_once (__DIR__ . '/../internals/base.php');
	require_once (__DIR__ . '/../internals/database.php');
	require_once (__DIR__ . '/../internals/highscores.php');

	Database::connect();

	$games = Highscores::getAllGames();

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