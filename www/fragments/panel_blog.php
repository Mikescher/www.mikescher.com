<?php
	require_once(__DIR__ . '/../internals/blog.php');
	
	$allposts = Blog::listAllNewestFirst();
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="/blog">New posts</a>
	</div>
	<div class="index_pnl_content blog_pnl_content">

        <?php

        for ($i=0; $i<3; $i++)
        {
			$post = $allposts[$i];

			if (!$post['visible']) continue;

			echo "<a class='blogpnl_base' href='" . $post['url'] . "'>\n";
			echo "<div class='blogpnl_date'>"  . $post['date'] . "</div>\n";
			echo "<div class='blogpnl_title'>"  . $post['title'] . "</div>\n";
			echo "</a>\n";

        }

        ?>

	</div>

</div>