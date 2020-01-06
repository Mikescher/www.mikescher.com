<?php

global $PARAM_AOCCALENDAR;

$year       = $PARAM_AOCCALENDAR['year'];
$shownav    = $PARAM_AOCCALENDAR['nav'];
$linkheader = $PARAM_AOCCALENDAR['linkheader'];
$ajax       = $PARAM_AOCCALENDAR['ajax'];
$frame      = isset($PARAM_AOCCALENDAR['frame']) ? $PARAM_AOCCALENDAR['frame'] : true;
$frameid    = isset($PARAM_AOCCALENDAR['frameid']) ? $PARAM_AOCCALENDAR['frameid'] : ('aoc_frame_' . getRandomToken(16));

$assocdays = AdventOfCode::listSingleYearAssociative($year);
$prev_year = $shownav ? AdventOfCode::getPrevYear($year) : null;
$next_year = $shownav ? AdventOfCode::getNextYear($year) : null;

if ($ajax) includeAdditionalScript("/data/javascript/aoc_panel_interactive.js", 'defer', true);

?>

<?php if ($frame) echo '<div class="aoc_calendar_parent" id="' . $frameid . '">'; ?>
    <div class="aoc_calendar">
        <div class="aoc_calendar_header">
			<?php
			if ($prev_year !== null)
            {
                if ($ajax)
                    echo '<a href="javascript:void();" onclick="javascript:changeAOCPanel(' . $prev_year . ', ' . ($shownav?'true':'false') . ', ' . ($linkheader?'true':'false') . ', ' . ($ajax?'true':'false') . ', \'' . $frameid . '\')" class="aoc_calendar_header_link aoc_prev" >&lt;</a>';
                else
                    echo '<a href="' . AdventOfCode::getURLForYear($prev_year) . '" class="aoc_calendar_header_link aoc_prev" >&lt;</a>';
            }
			else
            {
                echo '<a href="#" class="aoc_calendar_header_link aoc_prev aoc_link_hidden" >&lt;</a>';
			}

			if ($linkheader) echo '<span class="aoc_calendar_header_title"><a href="' . AdventOfCode::getURLForYear($year) . '">'.$year.'</a></span>';
			else             echo '<span class="aoc_calendar_header_title">'.$year.'</span>';

			if ($next_year !== null)
            {
				if ($ajax)
					echo '<a href="javascript:void();" onclick="javascript:changeAOCPanel(' . $next_year . ', ' . ($shownav?'true':'false') . ', ' . ($linkheader?'true':'false') . ', ' . ($ajax?'true':'false') . ', \'' . $frameid . '\')" class="aoc_calendar_header_link aoc_next" >&gt;</a>';
				else
                    echo '<a href="' . AdventOfCode::getURLForYear($next_year) . '" class="aoc_calendar_header_link aoc_next" >&gt;</a>';
            }
			else
            {
                echo '<a href="" class="aoc_calendar_header_link aoc_next aoc_link_hidden" >&gt;</a>';
			}
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
<?php if ($frame) echo '</div>'; ?>
