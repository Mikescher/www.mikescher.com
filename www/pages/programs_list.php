<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$filter = $ROUTE->parameter['categoryfilter'];

$FRAME_OPTIONS->title = 'Programs';
$FRAME_OPTIONS->canonical_url = ($filter === '') ? ('https://www.mikescher.com/programs') : ('https://www.mikescher.com/programs/cat/' . $filter);
$FRAME_OPTIONS->activeHeader = 'programs';


$allprograms = $SITE->modules->Programs()->listAllNewestFirst($filter);
?>

<div class="blockcontent">

    <div class="contentheader"><h1>My programs</h1><hr/></div>

	<?php

	echo '<div class="prgl_parent">' . "\n";

	foreach ($allprograms as $prog)
	{
		$uilang = '';
		foreach (explode('|', $prog['ui_language']) as $lang) $uilang .= '<img src="' . $SITE->modules->Programs()->convertLanguageToFlag($lang).'" alt="'.$lang.'" />';

		echo '<a class="prgl_elem" href="'.$prog['url'].'">';
		echo '  <div class="prgl_elem_left">';
		echo '    <img src="' . $prog['preview_url'] . '" alt="Thumbnail '  . $prog['name'] . '" />';
		echo '  </div>';
		echo '  <div class="prgl_elem_right">';
		echo '    <div class="prgl_elem_title">' . htmlspecialchars($prog['name']) . '</div>';
		echo '    <div class="prgl_elem_sdesc">' . htmlspecialchars($prog['short_description']) . '</div>';
		echo '    <div class="prgl_elem_info">';
		echo '      <div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Date:</span><span class="prgl_elem_subinfo_data">'.$prog['add_date'].'</span></div>';
		echo '      <div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Language:</span><span class="prgl_elem_subinfo_data">'.$prog['prog_language'].'</span></div>';
		echo '      <div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">UI Language:</span><span class="prgl_elem_subinfo_data">'.$uilang.'</span></div>';
		echo '      <div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Category:</span><span class="prgl_elem_subinfo_data">'.$prog['category'].'</span></div>';
		echo '    </div>';
		echo '  </div>';
		echo '</a>' . "\n";
	}
	echo '</div>' . "\n";

	?>

</div>
