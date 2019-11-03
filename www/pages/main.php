<!DOCTYPE html>
<html lang="en">
<?php require_once (__DIR__ . '/../internals/base.php'); ?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com</title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/"/>
	<?php printHeaderCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE='home'; include (__DIR__ . '/../fragments/header.php');  ?>

	<div id="content" class="content-responsive">

		<?php include (__DIR__ . '/../fragments/panel_euler.php');  ?>

		<?php include (__DIR__ . '/../fragments/panel_programs.php');  ?>

		<?php include (__DIR__ . '/../fragments/panel_blog.php');  ?>

		<?php include (__DIR__ . '/../fragments/panel_books.php');  ?>

		<?php /* global $PARAM_AOCPANEL; $PARAM_AOCPANEL=['year'=>2018]; include (__DIR__ . '/../fragments/panel_aoc.php'); */  ?>
		<?php global $PARAM_AOCPANEL; $PARAM_AOCPANEL=['year'=>2019]; include (__DIR__ . '/../fragments/panel_aoc.php');  ?>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
<?php printAdditionalScripts(); ?>
<?php printAdditionalStylesheets(); ?>
</body>
</html>