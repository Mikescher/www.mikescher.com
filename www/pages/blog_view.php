<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');


$id = $OPTIONS['id'];
$subview = $OPTIONS['subview'];

$post = Blog::getFullBlogpost($id, $subview, $err);
if ($post === null) httpError(404, $err);

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - <?php echo htmlspecialchars($post['title']); ?></title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<?php printHeaderCSS(); ?>
	<?php echo '<link rel="canonical" href="' . $post['canonical'] . '"/>'; ?>
</head>
<body>
<div id="mastercontainer">

<?php
if      ($post['type'] == 'euler')                       $HEADER_ACTIVE = 'euler';
else if ($post['type'] == 'euler' && $post['issubview']) $HEADER_ACTIVE = 'aoc';
else                                                     $HEADER_ACTIVE = 'blog';

include (__DIR__ . '/../fragments/header.php');
?>

<div id="content" class="content-responsive">

	<div class="blockcontent">

		<div class="contentheader"><h1><?php echo htmlspecialchars($post['title']); ?></h1><hr/></div>

		<?php

        if ($post['type'] === 'plain') {

			include (__DIR__ . '/../fragments/blogview_plain.php');

		} elseif ($post['type'] === 'markdown') {

			include (__DIR__ . '/../fragments/blogview_markdown.php');

		} elseif ($post['type'] === 'euler') {

			if ($subview === '') include (__DIR__ . '/../fragments/blogview_euler_list.php');
			else                 include (__DIR__ . '/../fragments/blogview_euler_single.php');

		} elseif ($post['type'] === 'aoc') {

			if ($subview === '') include (__DIR__ . '/../fragments/blogview_aoc_list.php');
			else                 include (__DIR__ . '/../fragments/blogview_aoc_single.php');

		}
		?>

	</div>

</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
<?php printAdditionalScripts(); ?>
<?php printAdditionalStylesheets(); ?>
</body>
</html>