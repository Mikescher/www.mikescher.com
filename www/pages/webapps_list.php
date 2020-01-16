<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'External tools, apps and more';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/webapps';
$FRAME_OPTIONS->activeHeader = 'webapps';

$allapps = $SITE->modules->WebApps()->listAllNewestFirst();
?>

<div class="blockcontent">

    <div class="contentheader"><h1>Online tools, web apps and more</h1><hr/></div>

    <div class='webapplistelem_container'>
		<?php

		foreach ($allapps as $post)
		{
			echo "<a class='webapplistelem' href='" . $post['url'] . "'>\n";
			echo "<div class='wle_date'>"  . $post['date'] . "</div>\n";
			echo "<div class='wle_title'>"  . $post['title'] . "</div>\n";
			echo "</a>\n";
		}

		?>
    </div>

</div>
