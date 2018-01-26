<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
global $OPTIONS;
?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - About</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<link rel="canonical" href="https://www.mikescher.com/about"/>
	<?php printCSS(); ?>
	<?php includeScriptOnce("/data/javascript/egh.js", true, 'defer') ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'about'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

		<div class="aboutcontent">

			<div class="contentheader"><h1>About mikescher.com</h1><hr/></div>

            <!------------------------------------------>

			<div class="boxedcontent">
				<div class="bc_header">About me</div>

				<div class="bc_data">

					<p>Welcome to my Mikescher.com</p>
					<p>This is my personal homepage, I use it to upload programs I have written, web serials I have style-setted and sometimes for a little bit of blogging.</p>
					<p>Its mostly just a collection of stuff I wanted to put only, but I guess thats the core of most personal homepages</p>


				</div>

			</div>

            <!------------------------------------------>

			<div class="boxedcontent">
				<div class="bc_header">My git timeline</div>

				<div class="bc_data about_egh_container">

					<?php if (file_exists(__DIR__ . '/../dynamic/egh.html')) include __DIR__ . '/../dynamic/egh.html' ?>

				</div>

			</div>

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">Other addresses</div>

                <div class="bc_data about_circles">

                    <a class="iconbutton_light" href="https://github.com/Mikescher">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#github"></use>
                        </svg>
                        <span>Github</span>
                    </a>
                    <a class="iconbutton_light" href="https://www.goodreads.com/C4terpillar">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#goodreads"></use>
                        </svg>
                        <span>Goodreads</span>
                    </a>
                    <a class="iconbutton_light" href="https://stackoverflow.com/users/1761622/mikescher">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#stackoverflow"></use>
                        </svg>
                        <span>Stackoverflow</span>
                    </a>
                    <a class="iconbutton_light" href="https://www.reddit.com/user/M1kescher/">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#reddit"></use>
                        </svg>
                        <span>Reddit</span>
                    </a>
                    <a class="iconbutton_light" href="http://www.delphipraxis.net/members/46235-mikescher.html">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                            <use xlink:href="/data/images/icons.svg#delphipraxis"></use>
                        </svg>
                        <span>Delphi-Praxis</span>
                    </a>

                </div>

            </div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>