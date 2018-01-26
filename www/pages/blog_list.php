<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');

$allposts = Blog::listAllNewestFirst();

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Blog</title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/blog"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

<?php $HEADER_ACTIVE='blog'; include (__DIR__ . '/../fragments/header.php');  ?>

<div id="content" class="content-responsive">

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

</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>