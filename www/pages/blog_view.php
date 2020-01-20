<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$id      = $ROUTE->parameter['id'];
$subview = $ROUTE->parameter['subview'];

$post = $SITE->modules->Blog()->getFullBlogpost($id, $subview, $err);
if ($post === null) { $FRAME_OPTIONS->setForced404($err); return; }

$FRAME_OPTIONS->title = $post['title'];
$FRAME_OPTIONS->canonical_url = $post['canonical'];

if ($post['type'] == 'euler')
	$FRAME_OPTIONS->activeHeader = 'euler';
else if ($post['type'] == 'aoc')
	$FRAME_OPTIONS->activeHeader = 'aoc';
else
	$FRAME_OPTIONS->activeHeader = 'blog';
?>


<div class="blockcontent">

    <div class="contentheader"><h1><?php echo htmlspecialchars($post['title']); ?></h1><hr/></div>

	<?php

	if ($post['type'] === 'plain')
	{
	    echo $SITE->fragments->BlogviewPlain($post);
	}
	elseif ($post['type'] === 'markdown')
    {
		echo $SITE->fragments->BlogviewMarkdown($post);
	}
	elseif ($post['type'] === 'euler')
    {
		if ($subview === '') echo $SITE->fragments->BlogviewEulerList($post);
		else                 echo $SITE->fragments->BlogviewEulerSingle($post, $subview);
	}
	elseif ($post['type'] === 'aoc')
    {
		if ($subview === '') echo $SITE->fragments->BlogviewAdventOfCodeList($post);
		else                 echo $SITE->fragments->BlogviewAdventOfCodeSingle($post, $subview);
	}
	?>

</div>

