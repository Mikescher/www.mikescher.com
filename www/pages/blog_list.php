<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');

$allposts = Blog::listAllOrderedDescending();

?>
<?php require_once (__DIR__ . '/../internals/base.php'); ?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Blog</title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<link rel="stylesheet" href="/data/css/styles.css"/>
</head>
<body>
<div id="mastercontainer">

<?php include (__DIR__ . '/../fragments/header.php');  ?>

<div id="content" class="content-responsive">

	<div class="blockcontent">

		<div class="contentheader"><h1>Blogposts and other stuff</h1><hr/></div>

		<div class='bloglistelem_container'>
			<?php

			foreach ($allposts as $post)
			{
				if (!$post['visible']) continue;

				if ($post['cat']=='blog')     echo "<a class='bloglistelem ble_blog' href='/blog/" . $post['id'] . "/" . urlencode($post['title']) . "'>";
				else if ($post['cat']=='log') echo "<a class='bloglistelem ble_log' href='/log/"  . $post['id'] . "'>";
				echo "<div class='ble_date'>"  . $post['date'] . "</div>";
				echo "<div class='ble_title'>"  . $post['title'] . "</div>";
				echo "</a>";
			}

			?>
		</div>

	</div>

</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>