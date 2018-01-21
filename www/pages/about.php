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

			<div class="boxedcontent">
				<div class="bc_header">About me</div>

				<div class="bc_data">

					<p>Welcome to my private homepage.</p>
					<p>My name is Mike, and this is my homepage. I use it to upload programs I have written and sometimes for a little bit of blogging.</p>
					<p>There are also sections about Project Euler, self-printed books and more</p>

				</div>

			</div>

			<div class="boxedcontent">
				<div class="bc_header">My git timeline</div>

				<div class="bc_data about_egh_container">

					<?php if (file_exists(__DIR__ . '/../dynamic/egh.html')) include __DIR__ . '/../dynamic/egh.html' ?>

				</div>

			</div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>