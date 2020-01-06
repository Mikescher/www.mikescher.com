<?php
require_once(__DIR__ . '/../internals/adventofcode.php');

$years = AdventOfCode::listYears();
$year = end($years);
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="<?php echo AdventOfCode::getURLForYear($year); ?>">Advent of Code</a>
	</div>
	<div class="index_pnl_content">

		<?php
            global $PARAM_AOCCALENDAR;
            $PARAM_AOCCALENDAR = ['year' => $year, 'nav'=>true, 'linkheader'=>true, 'ajax'=>true];
            require (__DIR__ . '/../fragments/panel_aoc_calendar.php')
        ?>

	</div>

</div>