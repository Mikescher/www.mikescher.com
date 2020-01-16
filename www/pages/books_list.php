<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Converted Books';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/books';
$FRAME_OPTIONS->activeHeader = 'books';

$allbooks = $SITE->modules->Books()->listAllNewestFirst();
?>

<div class="blockcontent booklst_content">

    <div class="contentheader"><h1>Books/<wbr>Webserials I self-printed</h1><hr/></div>

    <p>
        These are some books I read but that do not have an official print version.<br />
        So I type-setted them myself (mostly in <a href="https://www.lyx.org/">LyX</a>) and printed them <a href="https://www.epubli.de/">online</a>.<br />
        I do <b>not</b> own the rights of any of these books.<br />
        The LyX files and generated PDF's are public and everyone who wants can print them on his own.
    </p>

	<?php

	echo '<div class="booklst_parent">' . "\n";
	foreach ($allbooks as $book)
	{
		echo '<a class="booklst_entry" href="'.$book['url'].'">';
		echo '  <div class="booklst_left">';
		echo '    <img src="' . $book['preview_url'] . '" alt="Thumbnail '  . $book['title'] . '" />';
		echo '  </div>';
		echo '  <div class="booklst_right">';
		echo '    <div class="booklst_date"><span>' . $book['date'] . '</span></div>';
		echo '    <div class="booklst_title">' . htmlspecialchars($book['title']) . '</div>';
		echo '  </div>';
		echo '</a>' . "\n";
	}
	echo '</div>' . "\n";

	?>

</div>
