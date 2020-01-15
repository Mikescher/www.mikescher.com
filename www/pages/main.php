<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php include (__DIR__ . '/../fragments/panel_euler.php');  ?>

<?php include (__DIR__ . '/../fragments/panel_programs.php');  ?>

<?php include (__DIR__ . '/../fragments/panel_blog.php');  ?>

<?php include (__DIR__ . '/../fragments/panel_books.php');  ?>

<?php include (__DIR__ . '/../fragments/panel_aoc.php');  ?>