<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/books.php');

$allbooks = Books::listAllNewestFirst();

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Converted Books</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/books"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'books'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

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

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>