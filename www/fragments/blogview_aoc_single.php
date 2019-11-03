<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/adventofcode.php');
require_once (__DIR__ . '/../internals/ParsedownCustom.php');

$year = $post['extras']['aoc:year'];
$subview = $OPTIONS['subview'];

$day = AdventOfCode::getDayFromStrIdent($year, $subview);
if ($day === NULL) httpError(404, 'AdventOfCode entry not found');

$pd = new ParsedownCustom();

?>

<div class="boxedcontent base_markdown">

    <div style="position: relative;">
        <a href="<?php echo AdventOfCode::getGithubLink($year); ?>" style="position: absolute; top: 0; right: 0; border: 0;">
            <img src="/data/images/blog/github_band.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
        </a>
    </div>

	<div class="bc_header">
		<?php echo $day['date']; ?>
	</div>

	<div class="bc_data">

        <div class="bce_header"><h1><a href="<?php echo $day['url_aoc']; ?>">Day <?php echo $day['day-padded']; ?></a>: <?php echo htmlspecialchars($day['title']); ?></h1></div>

        <b>Description:</b>
        <div class="bc_aoc_description"><?php echo nl2br(htmlspecialchars(file_get_contents($day['file_challenge']))); ?></div>
        <br/>

        <b>Input:</b>
        <div class="bc_aoc_input"><?php echo nl2br(htmlspecialchars(file_get_contents($day['file_input']))); ?></div>
        <br/>

		<?php for ($i=1; $i<=$day['parts']; $i++): ?>

            <b>Part <?php echo $i; ?>:</b>
            <div class="bc_aoc_solution_parent">
                <div class="bc_aoc_solution_code">
                    <pre><code class="<?php echo AdventOfCode::getLanguageCSS($day) ?>"><?php echo htmlspecialchars(AdventOfCode::getSolutionCode($day, $i-1)); ?></code></pre>
                </div>
                <div class="bc_aoc_solution_value"><b>Result:</b> <?php echo $day['solutions'][$i-1]; ?></div>
            </div>
            <br/>

		<?php endfor; ?>

		<?php includeAdditionalScript("/data/javascript/prism.js", 'defer'); ?>
		<?php includeAdditionalStylesheet("/data/rawcss/prism.css"); ?>

        <br />
        <br />

        <?php
            global $PARAM_AOCCALENDAR;
            $PARAM_AOCCALENDAR = ['year' => $year, 'nav'=>false];
            require (__DIR__ . '/../fragments/panel_aoc_calendar.php')
        ?>

	</div>
</div>