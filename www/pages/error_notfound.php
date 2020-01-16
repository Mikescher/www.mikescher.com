<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$message = isset($ROUTE->parameter['message']) ? $ROUTE->parameter['message'] : '';

$FRAME_OPTIONS->title = 'Mikescher.com - ' . $message;
$FRAME_OPTIONS->canonical_url = null;
$FRAME_OPTIONS->activeHeader = null;
$FRAME_OPTIONS->contentCSSClasses []= 'content-fullheight';
?>


<div class="ev_master">
    <div class="ev_code">404</div>
    <?php if ($message !== ''): ?>
    <div class="ev_msg"><?php echo $message; ?></div>
	<?php endif; ?>
</div>