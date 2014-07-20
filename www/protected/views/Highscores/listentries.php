<?php
/* @var $this HighscoresController */
/* @var $game HighscoreGames */
/* @var $start int */
/* @var $highlight int */
/* @var $pagesize int */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

		table {
			margin: auto;
			width: 80%;
			text-align: center;
			border-spacing: 0px;
		}

		table td {
			padding: 2px 0px;
		}

		caption {
			font-weight: bolder;
			text-decoration: underline;
			font-size: x-large;
		}

		a {
			color: #008;
			text-decoration: underline;
		}

		a:hover { text-decoration: none; }

		#headline > td { text-decoration: underline; }
		#highlight {
			font-weight: bolder;
			background-color: #CCF;
		}
		-->
	</style>

</head>
<body>
<table>
	<caption><?php echo  $game->NAME; ?></caption>
	<tr id="headline" >
		<td>rank</td>
		<td>points</td>
		<td>name</td>
	</tr>

	<?php

	$current = 0;
	foreach ($game->ENTRIES as $entry)
	{
		$current++;

		if ($current >= $start && $current - $start <= $pagesize)
		{
			if ($current == $highlight)
				echo '<tr id="highlight">';
			else
				echo "<tr>";
        	echo "<td>$current</td>";
        	echo "<td>$entry->POINTS</td>";
        	echo "<td>$entry->PLAYER</td>";
      		echo "</tr>";
		}
	}

	$more = max(0, $start - $pagesize);
	$less = $start + $pagesize;

	echo '<tr>';
	if ($start > 0)
		echo '<td><a href="' . "/Highscores/list?gameid=$game->ID&start=$more&highlight=$highlight" . '">[more points]</a></td>';
	else
		echo '<td></td>';
	echo '<td></td>';
	if ($start + $pagesize < count($game->ENTRIES))
		echo '<td><a href="' . "/Highscores/list?gameid=$game->ID&start=$less&highlight=$highlight" . '">[less points]</a></td>';
	else
		echo '<td></td>';
	echo '</tr>';

	?>
</table>
</body>
</html>