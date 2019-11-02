<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/adventofcode.php');

$year = $post['extras']['aoc:year'];

$assocdays = AdventOfCode::listSingleYearAssociative($year);

$prev_year = AdventOfCode::getPrevYear($year);
$next_year = AdventOfCode::getNextYear($year);

?>

<div class="boxedcontent blogcontent_plain">

    <div style="position: relative;">
        <a href="<?php echo AdventOfCode::getGithubLink($year); ?>" style="position: absolute; top: 0; right: 0; border: 0;">
            <img src="/data/images/blog/github_band.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
        </a>
    </div>

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

    <div class="bc_data">

		<?php echo nl2br(Blog::getPostFragment($post)); ?>

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

    </div>
</div>