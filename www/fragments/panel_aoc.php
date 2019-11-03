<?php
require_once(__DIR__ . '/../internals/adventofcode.php');

    global $PARAM_AOCPANEL;
    $year = $PARAM_AOCPANEL['year'];
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="<?php echo AdventOfCode::getURLForYear($year); ?>">Advent of Code <?php echo $year; ?></a>
	</div>
	<div class="index_pnl_content">

		<?php
            global $PARAM_AOCCALENDAR;
            $PARAM_AOCCALENDAR = ['year' => $year, 'nav'=>false];
            require (__DIR__ . '/../fragments/panel_aoc_calendar.php')
        ?>

	</div>

</div>