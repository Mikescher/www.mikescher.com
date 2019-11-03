<?php

global $PARAM_AOCCALENDAR;

$year      = $PARAM_AOCCALENDAR['year'];

$assocdays = AdventOfCode::listSingleYearAssociative($year);
$prev_year = AdventOfCode::getPrevYear($year);
$next_year = AdventOfCode::getNextYear($year);

?>

<div class="aoc_calendar_parent">
    <div class="aoc_calendar">
        <div class="aoc_calendar_header">
			<?php
			if ($prev_year !== null) echo '<a href="' . AdventOfCode::getURLForYear($prev_year) . '" class="aoc_calendar_header_link aoc_prev" >&lt;</a>';
			else echo '<a href="#" class="aoc_calendar_header_link aoc_prev aoc_link_hidden" >&lt;</a>';

			echo '<span class="aoc_calendar_header_title">'.$year.'</span>';

			if ($next_year !== null) echo '<a href="' . AdventOfCode::getURLForYear($next_year) . '" class="aoc_calendar_header_link aoc_next" >&gt;</a>';
			else echo '<a href="" class="aoc_calendar_header_link aoc_next aoc_link_hidden" >&gt;</a>';
			?>
        </div>

		<?php
		for ($i=0; $i<5; $i++)
		{
			echo '<div class="aoc_calendar_row">'."\n";
			for ($j=0; $j<5; $j++)
			{
				$day = $assocdays[$i*5+$j];
				if ($day === null) echo '<span                     class="aoc_calendar_field aoc_disabled">'.($i*5+$j+1).'</span>'."\n";
				else               echo '<a href="'.$day['url'].'" class="aoc_calendar_field aoc_enabled" >'.($i*5+$j+1).'</a>'."\n";
			}
			echo '</div>'."\n";
		}
		?>
    </div>
</div>
