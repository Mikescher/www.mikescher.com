<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/books.php');


$id = $OPTIONS['id'];

$book = Books::getBook($id);
if ($book === NULL) httpError(404, 'Book not found');

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - <?php echo $book['title']; ?></title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<?php printCSS(); ?>
	<?php echo '<link rel="canonical" href="' . $book['url'] . '"/>'; ?>
	<?php includeScriptOnce("/data/javascript/ms_basic.js", true, 'defer') ?>
</head>
<body>
<div id="mastercontainer">

<?php $HEADER_ACTIVE = 'book'; include (__DIR__ . '/../fragments/header.php'); ?>

<div id="content" class="content-responsive">

	<div class="blockcontent">

        <div class="bookv_content">

            <div class="contentheader" id="bookv_header"><h1><?php echo htmlspecialchars($book['title']); ?></h1><hr/></div>

            <div class="bookv_top">
                <div class="bookv_left"><img src="<?php echo $book['imgfull_url']; ?>" alt="<?php echo $book['title'] ?>" /></div>
                <div class="bookv_right">
                    <div class="bookv_right_key"   style="grid-row:1">Name:</div>
                    <div class="bookv_right_value" style="grid-row:1"><?php echo htmlspecialchars($book['title_short']) ?></div>

                    <div class="bookv_right_key"   style="grid-row:2">Pages:</div>
                    <div class="bookv_right_value" style="grid-row:2"><?php echo $book['pages'] ?></div>

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
                            <span><?php echo Books::getRepositoryHost($book);  ?></span>
                        </a>
                        <a class="iconbutton" href="<?php echo $book['online'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                                <use xlink:href="/data/images/icons.svg#home"/>
                            </svg>
                            <span>Homepage</span>
                        </a>
                        <a class="iconbutton" href="<?php echo $book['pdf'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                                <use xlink:href="/data/images/icons.svg#pdf"/>
                            </svg>
                            <span>PDF</span>
                        </a>

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

        </div>
	</div>
</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>