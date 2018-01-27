<?php
	require_once(__DIR__ . '/../internals/books.php');
	
	$allbooks = Books::listAllNewestFirst();
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="/books">Converted books</a>
	</div>
	<div class="index_pnl_content books_pnl_content">

        <?php

        for ($i=0; $i<min(6, count($allbooks)); $i++)
        {
            $book = $allbooks[$i];

            $extra = $i>=2 ? 'books_pnl_extra' : '';

			echo "<a class='books_pnl_entry $extra' href='" . $book['url'] . "'>";
			echo '    <img src="' . $book['preview_url'] . '" alt="'  . $book['title'] . ' " />' . "\n";
			echo "<div class='books_pnl_caption'>" . htmlspecialchars($book['title_short']) . "</div>";
			echo "";
			echo "</a>";

        }

        ?>

	</div>

</div>