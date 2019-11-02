<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');


$id = $OPTIONS['id'];
$subview = $OPTIONS['subview'];

$post = Blog::getBlogpost($id);
if ($post === NULL) httpError(404, 'Blogpost not found');

$isSubEuler  = ($post['type'] === 'euler' && $subview !== '');
$isBaseEuler = ($post['type'] === 'euler');
$eulerproblem = null;
if ($isSubEuler)
{
	require_once(__DIR__ . '/../internals/euler.php');
	$eulerproblem = Euler::getEulerProblemFromStrIdent($subview);
}
if ($eulerproblem === null) $isSubEuler = false;

$isSubAdventOfCode = ($post['type'] === 'aoc' && $subview !== '');
$isAdventOfCode    = ($post['type'] === 'aoc');
$adventofcodeday = null;
if ($isSubAdventOfCode)
{
	require_once(__DIR__ . '/../internals/adventofcode.php');
	$adventofcodeday = AdventOfCode::getDayFromStrIdent($post['extras']['aoc:year'], $subview);
}
if ($adventofcodeday === null) $isSubAdventOfCode = false;

$htmltitle = $post['title'];
if ($isSubEuler) $htmltitle = $eulerproblem['title'];
if ($isSubAdventOfCode) $htmltitle = $adventofcodeday['title'];

$canonical = $post['canonical'];
if ($isSubEuler) $canonical = $eulerproblem['canonical'];
if ($isSubAdventOfCode) $canonical = $adventofcodeday['canonical'];

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - <?php echo $htmltitle; ?></title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<?php printCSS(); ?>
	<?php echo '<link rel="canonical" href="' . $canonical . '"/>'; ?>

</head>
<body>
<div id="mastercontainer">

<?php $HEADER_ACTIVE = (($isSubEuler || $isBaseEuler) ? 'euler' : 'blog'); include (__DIR__ . '/../fragments/header.php'); ?>

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
</body>
</html>