<!DOCTYPE html>
<html lang="en">
<?php
    require_once (__DIR__ . '/../internals/base.php');
    global $OPTIONS;

    $errorcode = $OPTIONS['code'];
    $errormsg  = $OPTIONS['message'];
?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - <?php echo $errormsg; ?></title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE='none'; include (__DIR__ . '/../fragments/header.php');  ?>

<div id="content" class="content-responsive content-fullheight">

    <div class="ev_master">
        <div class="ev_code"><?php echo $errorcode; ?></div>
        <div class="ev_msg"><?php echo $errormsg; ?></div>
    </div>

</div>

</div>
</body>
</html>