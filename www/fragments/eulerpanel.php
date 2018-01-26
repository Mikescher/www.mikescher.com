<?php
	require_once(__DIR__ . '/../internals/euler.php');
	
	$euler = Euler::listAll();

	$RATING_CLASSES = ['euler_pnl_celltime_perfect', 'euler_pnl_celltime_good', 'euler_pnl_celltime_ok', 'euler_pnl_celltime_bad', 'euler_pnl_celltime_fail'];
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="/blog/1/Project_Euler_with_Befunge">Project Euler with Befunge-93</a>
	</div>
	<div class="index_pnl_content">

	<?php

	$arr = [];

	$max = 0;
	foreach ($euler as $problem)
	{
		$max = max($max, $problem['number']);
		$arr[$problem['number']] = $problem;
	}

	$max = ceil($max / 20 + 1) * 20;

	echo "<div class='euler_pnl_row'>\n";
	echo "<div class='euler_pnl_row2'>\n";
	for ($i = 1; $i <= $max; $i++)
	{
		$cssclass = 'euler_pnl_cell_notexist';
		$alttitle = '';
		$href = '#';
		if (key_exists($i, $arr))
		{
			$cssclass = $RATING_CLASSES[$arr[$i]['rating']];
			$alttitle = $arr[$i]['title'];
			$href = "/blog/1/Project_Euler_with_Befunge/problem-" . str_pad($i, 3, '0', STR_PAD_LEFT);
		}

		echo "  <div class=\"euler_pnl_cell $cssclass\">";
		echo "<a href=\"" . $href . "\" title=\"" . htmlspecialchars($alttitle) . "\" >";
		echo "$i";
		echo "</a>";
		echo "</div>\n";

		if (($i)%20 == 0)
		{
			echo "</div>\n";
			echo "</div>\n";
			echo "<div class='euler_pnl_row'>\n";
			echo "<div class='euler_pnl_row2'>\n";
		}
		else if (($i)%10 == 0)
		{
			echo "</div>\n";
			echo "<div class='euler_pnl_row2'>\n";
		}
	}
	echo "</div>\n";
	echo "</div>\n";

	?>
	</div>

</div>