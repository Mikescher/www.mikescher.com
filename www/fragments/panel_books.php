<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

global $FRAGMENT_PARAM;
/** @var array $parameter */
$parameter = $FRAGMENT_PARAM;
?>

<?php
$allbooks = $SITE->modules->Books()->listAllNewestFirst();
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="/books">Self-printed books</a>
	</div>
	<div class="index_pnl_content books_pnl_content">

        <?php

        for ($i=0; $i<min(6, count($allbooks)); $i++)
        {
            $book = $allbooks[$i];

            $extra = $i>=2 ? 'books_pnl_extra' : '';

			$extraStyle = 'font-size: ' . $book['grid_fsize'];

			echo "<a class=\"books_pnl_entry $extra\" style=\"$extraStyle\" href='" . $book['url'] . "'>";
			echo '    <img src="' . $book['preview_url'] . '" alt="'  . $book['title'] . ' " />' . "\n";
			echo "<div class='books_pnl_caption'>" . htmlspecialchars($book['title_short']) . "</div>";
			echo "";
			echo "</a>";

        }

        ?>

	</div>

</div>