<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/programs.php');

$filter = $OPTIONS['categoryfilter'];

$allprograms = Programs::listAllNewestFirst($filter);

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Programs</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/programs"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'programs'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

		<div class="blockcontent">

			<div class="contentheader"><h1>My programs</h1><hr/></div>


            <?php

			echo '<div class="prgl_parent">' . "\n";
            foreach ($allprograms as $prog)
            {
                $uilang = '';
				foreach (explode('|', $prog['ui_language']) as $lang) $uilang .= '<img src="'.convertLanguageToFlag($lang).'" alt="'.$lang.'" />';

				echo '<a class="prgl_elem" href="'.$prog['url'].'">';
				echo '<div class="prgl_elem_left">';
				echo '<img src="' . $prog['thumbnail_url'] . '" alt="Thumbnail '  . $prog['name'] . '" />';
				echo '</div>';
				echo '<div class="prgl_elem_right">';
				echo '<div class="prgl_elem_title">' . htmlspecialchars($prog['name']) . '</div>';
				echo '<div class="prgl_elem_info">';
				echo '<div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Date:</span><span class="prgl_elem_subinfo_data">'.$prog['add_date'].'</span></div>';
				echo '<div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Language:</span><span class="prgl_elem_subinfo_data">'.$prog['prog_language'].'</span></div>';
				echo '<div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">UI Language:</span><span class="prgl_elem_subinfo_data">'.$uilang.'</span></div>';
				echo '<div class="prgl_elem_subinfo"><span class="prgl_elem_subinfo_caption">Category:</span><span class="prgl_elem_subinfo_data">'.$prog['category'].'</span></div>';
				echo '</div>';
				echo '</div>';
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