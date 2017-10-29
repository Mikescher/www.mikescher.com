
<?php

    $euler = $PDO->query('SELECT * FROM ms4_eulerproblem', PDO::FETCH_ASSOC);

?>

<div class="euler_pnl_base">

    <div class="euler_pnl_header">
        Project Euler with Befunge-93
    </div>
    <div class="euler_pnl_content">

	<?php

    $arr = [];

    $max = 0;
    foreach ($euler as $problem)
    {
        $max = max($max, $problem['Problemnumber']);


		if ($problem['SolutionTime'] < 100) // < 100ms
			$problem['timelevel'] = 'euler_pnl_celltime_perfect';
		else if ($problem['SolutionTime'] < 15 * 1000) // < 5s
			$problem['timelevel'] = 'euler_pnl_celltime_good';
		else if ($problem['SolutionTime'] < 60 * 1000) // < 1min
			$problem['timelevel'] = 'euler_pnl_celltime_ok';
		else if ($problem['SolutionTime'] < 5 * 60 * 1000) // < 5min
			$problem['timelevel'] = 'euler_pnl_celltime_bad';
		else
			$problem['timelevel'] = 'euler_pnl_celltime_fail';

		$arr[$problem['Problemnumber']] = $problem;
	}

	$max = ceil($max / 20) * 20;

    echo "<div class='euler_pnl_row'>\n";
	echo "<div class='euler_pnl_row2'>\n";
    for ($i = 1; $i <= $max; $i++)
    {
        $cssclass = '';
        if (key_exists($i, $arr))
        {
			$cssclass = $arr[$i]['timelevel'];
        }
        else
        {
			$cssclass = 'euler_pnl_cell_notexist';
        }

		echo "  <div class=\"euler_pnl_cell $cssclass\">";
		echo "<a href=\"/blog/1/Project_Euler_with_Befunge/problem-" . str_pad($i, 3, '0', STR_PAD_LEFT) . "\">";
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