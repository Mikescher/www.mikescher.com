<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Blog';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/blog';
$FRAME_OPTIONS->activeHeader = 'blog';

$allposts = $SITE->modules->Blog()->listAllNewestFirst();
?>

<div class="blockcontent">

    <div class="contentheader"><h1>Blogposts and other stuff</h1><hr/></div>

    <div class='bloglistelem_container'>
		<?php

		foreach ($allposts as $post)
		{
			if (!$post['visible']) continue;

			if ($post['cat']=='blog')     echo "<a class='bloglistelem ble_blog' href='" . $post['url'] . "'>\n";
			else if ($post['cat']=='log') echo "<a class='bloglistelem ble_log' href='"  . $post['url'] . "'>\n";
			echo "<div class='ble_date'>"  . $post['date'] . "</div>\n";
			echo "<div class='ble_title'>"  . $post['title'] . "</div>\n";
			echo "</a>\n";
		}

		?>
    </div>

</div>
