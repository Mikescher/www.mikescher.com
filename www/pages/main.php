<!DOCTYPE html>
<html lang="en">
<?php require_once (__DIR__ . '/../internals/base.php'); ?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com</title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE='home'; include (__DIR__ . '/../fragments/header.php');  ?>

	<div id="content" class="content-responsive">

		<?php include (__DIR__ . '/../fragments/eulerpanel.php');  ?>

		<?php include (__DIR__ . '/../fragments/programspanel.php');  ?>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>