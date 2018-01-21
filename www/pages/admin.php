<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - About</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<link rel="canonical" href="https://www.mikescher.com/about"/>
	<?php printCSS(); ?>
	<?php includeScriptOnce("http://code.jquery.com/jquery-latest.min.js", true, '') ?>
	<?php includeScriptOnce("/data/javascript/admin.js", true, 'defer') ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'admin'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

		<div class="admincontent">

			<div class="contentheader"><h1>Admin</h1><hr/></div>

			<div class="boxedcontent">
				<div class="bc_header">Version</div>

                <div class="bc_data">
                    <div><b style="display:inline-block; min-width: 100px">Branch:&nbsp;</b><span><?php echo exec('git rev-parse --abbrev-ref HEAD'); ?></span></div>
                    <div><b style="display:inline-block; min-width: 100px">Commit:&nbsp;</b><span><?php echo exec('git rev-parse HEAD'); ?></span></div>
                    <div><b style="display:inline-block; min-width: 100px">Date:&nbsp;</b><span><?php echo exec('git log -1 --format=%cd'); ?></span></div>
                    <div><b style="display:inline-block; min-width: 100px">Message:&nbsp;</b><span><?php echo nl2br(exec('git log -1')); ?></span></div>
                </div>

			</div>

            <div class="boxedcontent">
                <div class="bc_header">ExtendedGitGraph</div>

                <div class="bc_data">

                    <textarea class="egh_ajaxOutput" id="egh_ajaxOutput" readonly="readonly"></textarea>
                    <a class="button" href="javascript:startAjaxRefresh('<?php echo $CONFIG['ajax_secret'] ?>')">Update</a>
                    <a class="button" href="javascript:startAjaxRedraw('<?php echo $CONFIG['ajax_secret'] ?>')">Redraw</a>

                </div>

            </div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>