<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');


$id = $OPTIONS['id'];
$subview = $OPTIONS['subview'];

$post = Blog::getBlogpost($id);

if ($post === NULL) httpError(404, 'blogpost not found');

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Blog</title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="stylesheet" href="/data/css/styles.css"/>
    <link rel="canonical" href="<?php echo (($subview !== '') ? ($post['canonical']) : ($post['canonical'] . '/' . $subview)); ?>"/>
</head>
<body>
<div id="mastercontainer">

<?php include (__DIR__ . '/../fragments/header.php');  ?>

<div id="content" class="content-responsive">

	<div class="blockcontent">

		<div class="contentheader"><h1><?php echo htmlspecialchars($post['title']); ?></h1><hr/></div>

		<?php

        if ($post['type'] === 'plain') {

			include (__DIR__ . '/../fragments/blogview_plain.php');

		} elseif ($post['type'] === 'markdown') {

			include (__DIR__ . '/../fragments/blogview_markdown.php');

		} elseif ($post['type'] === 'bfjoust') {

			include (__DIR__ . '/../fragments/blogview_bfjoust.php');

		} elseif ($post['type'] === 'euler') {

			if ($subview === '') include (__DIR__ . '/../fragments/blogview_euler_list.php');
			else                 include (__DIR__ . '/../fragments/blogview_euler_single.php');

		}
		?>

	</div>

</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>