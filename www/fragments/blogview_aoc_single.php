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
        <div class="bc_aoc_description_parent"><div class="bc_aoc_description"><?php echo nl2br(htmlspecialchars(file_get_contents($day['file_challenge']))); ?></div></div>
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

        <div class="pagination">
            <?php
            $assocdays = AdventOfCode::listSingleYearAssociative($year);

            echo "<div class='pagAny'>";
            for($i=0; $i < 25; $i++)
            {
                if ($i>0 && $i%5 == 0) echo "</div><div class='pagAny'>";

                if ($assocdays[$i] === null) echo "<div class='pagbtn pagbtn_disabled'>" . ($i+1) . "</div>\n";
                else if ($i+1 === $day['day']) echo "<a class='pagbtn pagbtn_active' href='" . $assocdays[$i]['url'] . "'>" . ($i+1) . "</a>\n";
                else echo "<a class='pagbtn' href='" . $assocdays[$i]['url'] . "'>" . ($i+1) . "</a>\n";
            }
            echo "</div>";


            ?>
        </div>

	</div>
</div>