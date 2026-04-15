<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'VCS';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/vcs';
$FRAME_OPTIONS->activeHeader = 'vcs';
?>

<div class="aboutcontent">

    <div class="contentheader"><h1>My git timeline</h1><hr/></div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">My git timeline</div>

        <div class="bc_data about_egg_container">

			<?php
			$FRAME_OPTIONS->addScript('/data/javascript/extendedgitgraph.js', true);
            echo $SITE->modules->ExtendedGitGraph()->get();
            ?>

        </div>

    </div>

</div>
