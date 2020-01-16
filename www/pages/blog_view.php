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

$FRAME_OPTIONS->title = 'Mikescher.com - ' . $post['title'];
$FRAME_OPTIONS->canonical_url = $post['canonical'];

if ($post['type'] == 'euler')
	$FRAME_OPTIONS->activeHeader = 'euler';
else if ($post['type'] == 'euler' && $post['issubview'])
	$FRAME_OPTIONS->activeHeader = 'aoc';
else
	$FRAME_OPTIONS->activeHeader = 'blog';
?>


<div class="blockcontent">

    <div class="contentheader"><h1><?php echo htmlspecialchars($post['title']); ?></h1><hr/></div>

	<?php

	if ($post['type'] === 'plain')
	{
	    $SITE->fragments->BlogviewPlain($post);
	}
	elseif ($post['type'] === 'markdown')
    {
		$SITE->fragments->BlogviewMarkdown($post);
	}
	elseif ($post['type'] === 'euler')
    {
		if ($subview === '') $SITE->fragments->BlogviewEulerList($post);
		else                 $SITE->fragments->BlogviewEulerSingle($post, $subview);
	}
	elseif ($post['type'] === 'aoc')
    {
		if ($subview === '') $SITE->fragments->BlogviewAdventOfCodeList($post);
		else                 $SITE->fragments->BlogviewAdventOfCodeSingle($post, $subview);
	}
	?>

</div>

