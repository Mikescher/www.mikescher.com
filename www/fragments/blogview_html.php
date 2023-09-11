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

<div class="boxedcontent blogcontent_html">

    <?php if (isset($post['extras']['gh_link'])): ?>
        <div style="position: relative;">
            <a href="<?= $post['extras']['gh_link'] ?>" style="position: absolute; top: 0; right: 0; border: 0;">
                <img src="/data/images/blog/github_band.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
            </a>
        </div>
    <?php endif; ?>

    <div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
		<?php echo $SITE->modules->Blog()->getPostFragment($post); ?>
	</div>

</div>