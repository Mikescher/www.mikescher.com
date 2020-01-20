<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$id = $ROUTE->parameter['id'];

$prog = $SITE->modules->Programs()->getProgramByInternalName($id);
if ($prog === null) { $FRAME_OPTIONS->setForced404("Program not found"); return; }

$FRAME_OPTIONS->title = $prog['name'];
$FRAME_OPTIONS->canonical_url =$prog['url'];
$FRAME_OPTIONS->activeHeader = 'programs';
?>

<div class="blockcontent">

    <div class="prgv_content">

        <div class="contentheader" id="prgv_header"><h1><?php echo htmlspecialchars($prog['name']); ?></h1><hr/></div>

        <div class="prgv_top">

            <div class="prgv_left"><img src="<?php echo $prog['mainimage_url']; ?>" alt="Thumbnail (<?php echo $prog['name'] ?>)" /></div>

            <div class="prgv_right">
                <div class="prgv_right_key"   style="grid-row:1">Name:</div>
                <div class="prgv_right_value" style="grid-row:1"><a href="<?php echo $prog['url']; ?>"><?php echo htmlspecialchars($prog['name']) ?></a></div>

                <div class="prgv_right_key"   style="grid-row:2">Language:</div>
                <div class="prgv_right_value" style="grid-row:2"><?php echo htmlspecialchars($prog['prog_language']) ?></div>

				<?php if ($prog['license'] !== null): ?>
                    <div class="prgv_right_key"   style="grid-row:3">License:</div>
                    <div class="prgv_right_value" style="grid-row:3"><?php echo '<a href="'.$SITE->modules->Programs()->getLicenseUrl($prog['license']).'">'.$prog['license'].'</a>' ?></div>
				<?php endif; ?>

                <div class="prgv_right_key"   style="grid-row:4">Category:</div>
                <div class="prgv_right_value" style="grid-row:4"><?php echo htmlspecialchars($prog['category']) ?></div>

                <div class="prgv_right_key"   style="grid-row:5">Date:</div>
                <div class="prgv_right_value" style="grid-row:5"><?php echo htmlspecialchars($prog['add_date']) ?></div>

                <div class="prgv_right_comb"  style="grid-row:6">
					<?php
					foreach ($SITE->modules->Programs()->getURLs($prog) as $xurl)
					{
						echo '<a class="iconbutton '.$xurl['css'].'" href="'.$xurl['href'].'">';
						echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">';
						echo '<use xlink:href="/data/images/icons.svg#'.$xurl['svg'].'"/>';
						echo '</svg>';
						echo '<span>'.$xurl['caption'].'</span>';
						echo '</a>';
					}
					?>
                </div>

                <div class="prgv_right_comb prgv_right_lang" style="grid-row:8">
					<?php
					foreach (explode('|', $prog['ui_language']) as $lang)
					{
						echo '<img src="'.$SITE->modules->Programs()->convertLanguageToFlag($lang).'" title="'.$lang.'" alt="'.$lang[0].'" />' . "\n";
					}
					?>
                </div>
            </div>
        </div>

		<?php if ($prog['has_extra_images']): ?>

            <?php $FRAME_OPTIONS->addScript('/data/javascript/ms_basic.js', true); ?>

            <div class="progv_extra imgcarousel_parent" data-imgcarousel-index="0" data-imgcarousel-images="<?php echo htmlspecialchars(json_encode($prog['extraimages_urls'])); ?>" >
                <a class="imgcarousel_prev">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                        <use xlink:href="/data/images/icons.svg#arrow_left"/>
                    </svg>
                </a>
                <div class="imgcarousel_content" style="background-image: url(<?php echo $prog['extraimages_urls'][0]; ?>);"></div>
                <a class="imgcarousel_next">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                        <use xlink:href="/data/images/icons.svg#arrow_right"/>
                    </svg>
                </a>
            </div>

		<?php endif; ?>

        <hr class="prgv_sep" />

        <div class="prgv_center base_markdown">
			<?php echo $SITE->renderMarkdown($SITE->modules->Programs()->getProgramDescription($prog)); ?>
        </div>

    </div>

</div>
