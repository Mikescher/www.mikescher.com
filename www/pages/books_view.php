<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$id = $ROUTE->parameter['id'];

$book = $SITE->modules->Books()->getBook($id);
if ($book === null) { $FRAME_OPTIONS->setForced404("Books not found"); return; }

$FRAME_OPTIONS->title = $book['title'];
$FRAME_OPTIONS->canonical_url = $book['url'];
$FRAME_OPTIONS->activeHeader = 'books';

$FRAME_OPTIONS->addScript('/data/javascript/ms_basic.js', true);
?>


<div class="blockcontent">

    <div class="bookv_content">

        <div class="contentheader" id="bookv_header"><h1><?php echo htmlspecialchars($book['title']); ?></h1><hr/></div>

        <div class="bookv_top">
            <div class="bookv_left"><img src="<?php echo $book['imgfull_url']; ?>" alt="<?php echo $book['title'] ?>" /></div>
            <div class="bookv_right">
                <div class="bookv_right_key"   style="grid-row:1">Name:</div>
                <div class="bookv_right_value" style="grid-row:1"><?php echo htmlspecialchars($book['title_short']) ?></div>

                <div class="bookv_right_key"   style="grid-row:2">Pages:</div>
                <div class="bookv_right_value" style="grid-row:2"><?php
					if (is_string($book['pages']))
					{
						echo $book['pages'];
					}
					else
					{
						$pagi = 1;
						foreach ($book['pages'] as $page)
						{
							echo 'Buch ' . $pagi . ': ' . $page . '<br/>';
							$pagi++;
						}
					}
					?></div>

                <div class="bookv_right_key"   style="grid-row:3">Author:</div>
                <div class="bookv_right_value" style="grid-row:3"><?php echo htmlspecialchars($book['author']) ?></div>

                <div class="bookv_right_key"   style="grid-row:4">Size:</div>
                <div class="bookv_right_value" style="grid-row:4"><?php echo $book['size'][0] . 'cm x ' . $book['size'][1] . 'cm'; ?></div>

                <div class="bookv_right_key"   style="grid-row:5">Date:</div>
                <div class="bookv_right_value" style="grid-row:5"><?php echo $book['date'] ?></div>

                <div class="bookv_right_comb"  style="grid-row:6">

                    <a class="iconbutton" href="<?php echo $book['repository'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#github"/>
                        </svg>
                        <span><?php echo $SITE->modules->Books()->getRepositoryHost($book);  ?></span>
                    </a>
                    <a class="iconbutton" href="<?php echo $book['online'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#home"/>
                        </svg>
                        <span>Homepage</span>
                    </a>
					<?php if (is_string($book['pdf'])): ?>
                        <a class="iconbutton" href="<?php echo $book['pdf'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                                <use xlink:href="/data/images/icons.svg#pdf"/>
                            </svg>
                            <span>PDF</span>
                        </a>
					<?php else: ?>
						<?php $pdfi = 1; foreach ($book['pdf'] as $pdf): ?>
                            <a class="iconbutton" href="<?php echo $pdf ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                                    <use xlink:href="/data/images/icons.svg#pdf"/>
                                </svg>
                                <span>PDF (Buch <?php echo $pdfi; $pdfi++; ?>)</span>
                            </a>
						<?php endforeach; ?>
					<?php endif; ?>

                </div>
            </div>
        </div>

        <div class="bookv_extra imgcarousel_parent" data-imgcarousel-index="0" data-imgcarousel-images="<?php echo htmlspecialchars(json_encode($book['extraimages_urls'])); ?>" >
            <a class="imgcarousel_prev">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#arrow_left"/>
                </svg>
            </a>
            <div class="imgcarousel_content" style="background-image: url(<?php echo $book['extraimages_urls'][0]; ?>);"></div>
            <a class="imgcarousel_next">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#arrow_right"/>
                </svg>
            </a>
        </div>

        <div class="bookv_readme base_markdown">
			<?php echo $SITE->renderMarkdown($SITE->modules->Books()->getREADME($book)); ?>
        </div>

    </div>
</div>
