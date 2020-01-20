<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = '';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com';
$FRAME_OPTIONS->activeHeader = 'home';
?>

<?php echo $SITE->fragments->PanelEuler(); ?>

<?php echo $SITE->fragments->PanelPrograms(); ?>

<?php echo $SITE->fragments->PanelBlog(); ?>

<?php echo $SITE->fragments->PanelBooks(); ?>

<?php echo $SITE->fragments->PanelAdventOfCode(); ?>
