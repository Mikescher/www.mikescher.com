<?php
/* @var $this HighscoresController */
/* @var $games HighscoreGames[] */
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
		echo '<a href="' . $game->getListLink() . '">' . $game->NAME . '</a><br>' . "\r\n";
	}
?>

</body>
</html>