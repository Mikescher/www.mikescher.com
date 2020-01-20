<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$FRAME_OPTIONS->title = null;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->frame = 'api_frame.php';



$pagesize = 20;
$start = 0;
$highlight = 0;

if (isset($_GET["start"]))
{
    $start = intval(htmlspecialchars($_GET["start"])) - 1;
    if ($start < 0) $start = 0;
}

if (isset($_GET["highlight"]))
{
    $highlight= intval(htmlspecialchars($_GET["highlight"]));
}

$game = $SITE->modules->Highscores()->getGameByID($ROUTE->parameter['gameid']);

$entries = $SITE->modules->Highscores()->getOrderedEntriesFromGame($ROUTE->parameter['gameid']);
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

		table td { padding: 2px 0px; }
		table td { width: 25%; }
		table td:last-child { width: 50%; }

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
	<caption><?php echo  $game['NAME']; ?></caption>
	<tr id="headline" >
		<td>rank</td>
		<td>points</td>
		<td>name</td>
	</tr>

	<?php

	$current = 0;
	foreach ($entries as $entry)
	{
		$current++;

		if ($current >= $start && $current - $start <= $pagesize)
		{
			if ($current == $highlight)
				echo '<tr id="highlight">';
			else
				echo "<tr>";
        	echo "<td>$current</td>";
        	echo "<td>".$entry['POINTS']."</td>";
        	echo "<td>".$entry['PLAYER']."</td>";
      		echo "</tr>";
		}
	}

	$more = max(0, $start - $pagesize);
	$less = $start + $pagesize;

	echo '<tr>';
	if ($start > 0)
		echo '<td><a href="' . "/Highscores/list?gameid=".$game['ID']."&start=$more&highlight=$highlight" . '">[more points]</a></td>';
	else
		echo '<td></td>';
	echo '<td></td>';
	if ($start + $pagesize < count($entries))
		echo '<td><a href="' . "/Highscores/list?gameid=".$game['ID']."&start=$less&highlight=$highlight" . '">[less points]</a></td>';
	else
		echo '<td></td>';
	echo '</tr>';

	?>
</table>
</body>
</html>