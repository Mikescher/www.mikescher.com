<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Reading history';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/reading';
$FRAME_OPTIONS->activeHeader = 'reading';
?>

<div class="aboutcontent">

    <div class="contentheader"><h1>Reading history</h1><hr/></div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Tierlist <i>(auto-generated from Calibre, probably kinda questionable...)</i></div>

        <div class="bc_data about_tier_container">

            <?php echo $SITE->modules->EbookHistory()->getTierlist(); ?>

        </div>

    </div>

    <div class="boxedcontent">
        <div class="bc_header">Reading history <i>(incomplete :/)</i></div>

        <div class="bc_data about_ehr_container">

            <?php echo $SITE->modules->EbookHistory()->getHistory(); ?>

        </div>

    </div>

</div>
