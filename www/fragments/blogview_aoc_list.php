<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/adventofcode.php');

$year = $post['extras']['aoc:year'];

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

		<?php echo nl2br(htmlspecialchars(Blog::getPostFragment($post))); ?>


		<?php
            global $PARAM_AOCCALENDAR;
            $PARAM_AOCCALENDAR = ['year' => $year];
            require (__DIR__ . '/../fragments/panel_aoc_calendar.php')
		?>

    </div>
</div>