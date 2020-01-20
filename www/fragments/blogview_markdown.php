<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

global $FRAGMENT_PARAM;
/** @var array $parameter */
$parameter = $FRAGMENT_PARAM;
?>

<?php
$post = $parameter['blogpost'];
?>

<div class="boxedcontent blogcontent_markdown base_markdown">

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
		<?php echo $SITE->renderMarkdown($SITE->modules->Blog()->getPostFragment($post)); ?>
	</div>

</div>