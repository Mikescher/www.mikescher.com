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

        $c=0;
        for ($i=0; $i < count($allposts); $i++)
        {
			$post = $allposts[$i];

			if (!$post['visible']) continue;

			echo "<a class='blogpnl_base' href='" . $post['url'] . "'>\n";
			echo "<div class='blogpnl_date'>"  . $post['date'] . "</div>\n";
			echo "<div class='blogpnl_title'>"  . $post['title'] . "</div>\n";
			echo "</a>\n";

            $c++;
            if ($c >= 3) break;
        }

        ?>

	</div>

</div>