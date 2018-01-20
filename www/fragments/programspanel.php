<?php
	require_once(__DIR__ . '/../internals/programs.php');
	
	$allprograms = Programs::listAllNewestFirst();
?>

<div class="programs_pnl_base">

	<div class="programs_pnl_header">
        <a href="/programs">Newly added software</a>
	</div>
	<div class="programs_pnl_content">

        <?php

        for ($i=0; $i<6; $i++)
        {
            $prog = $allprograms[$i];

			echo '<a href="' . $prog['url'] . '" class="programs_pnl_entry">' . "\n";
			echo '  <div class="programs_pnl_img">' . "\n";
			echo '    <img src="' . $prog['thumbnail_url'] . '" alt="Thumbnail '  . $prog['name'] . ' " />' . "\n";
			echo '  </div>' . "\n";
			echo '  <div class="programs_pnl_center">' . "\n";
			echo htmlspecialchars($prog['name']) . "\n";
			echo '  </div>' . "\n";
			echo '  <div class="programs_pnl_bottom">' . "\n";
			echo '    <div class="programs_pnl_bottom_1">' . "\n";
			echo '      <span class="programs_pnl_bottom_sub_top">Date</span>' . "\n";
			echo '      <span class="programs_pnl_bottom_sub_bot">' . $prog['add_date'] . '</span>' . "\n";
			echo '    </div>' . "\n";
			echo '    <div class="programs_pnl_bottom_2">' . "\n";
			echo '      <span class="programs_pnl_bottom_sub_top">Language</span>' . "\n";
			echo '      <span class="programs_pnl_bottom_sub_bot">' . $prog['prog_language'] . '</span>' . "\n";
			echo '    </div>' . "\n";
			echo '  </div>' . "\n";
			echo '</a>' . "\n";

        }

        ?>

	</div>

</div>