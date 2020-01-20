<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Error';
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->contentCSSClasses []= 'content-fullheight';

$message   = $ROUTE->parameter['message'];
$debuginfo = $ROUTE->parameter['debuginfo'];
?>


<div class="ev_master">
	<div class="ev_code">500</div>
	<div class="ev_msg"><?php echo $message; ?></div>
	<?php if ($debuginfo !== null && strlen($debuginfo)>0 && ($SITE != null && !$SITE->isProd())): ?>
		<p class="ev_statusmore"><?php echo nl2br($debuginfo); ?></p>
	<?php endif; ?>
</div>