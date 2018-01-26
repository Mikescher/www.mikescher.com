<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/highscores.php');
require_once (__DIR__ . '/../internals/alephnoteStatistics.php');

Database::connect();

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

            <!------------------------------------------>

			<div class="boxedcontent">
				<div class="bc_header">Version</div>

                <div class="bc_data keyvaluelist kvl_100">
                    <div><span>Branch:</span> <span><?php echo exec('git rev-parse --abbrev-ref HEAD'); ?></span></div>
                    <div><span>Commit:</span> <span><?php echo exec('git rev-parse HEAD'); ?></span></div>
                    <div><span>Date:</span>   <span><?php echo exec('git log -1 --format=%cd'); ?></span></div>
                    <div><span>Message:</span><span><?php echo nl2br(trim(exec('git log -1'))); ?></span></div>
                </div>

			</div>

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">ExtendedGitGraph</div>

                <div class="bc_data">

                    <textarea class="egh_ajaxOutput" id="egh_ajaxOutput" readonly="readonly"></textarea>
                    <a class="button" href="javascript:startAjaxRefresh('<?php echo $CONFIG['ajax_secret'] ?>')">Update</a>
                    <a class="button" href="javascript:startAjaxRedraw('<?php echo $CONFIG['ajax_secret'] ?>')">Redraw</a>

                </div>

            </div>

            <div class="boxedcontent">
                <div class="bc_header">AlephNote</div>

                <div class="bc_data">
                    <div class="keyvaluelist kvl_200">
                        <div><span>Total users:</span> <span><?php echo 0; ?></span></div>
                        <div><span>Users on latest version:</span> <span><?php echo 0; ?></span></div>
                        <div><span>Active users:</span> <span><?php echo 0; ?></span></div>
                    </div>

                    <div id="an_ajax_target"></div>

                    <a class="button" href="javascript:showAlephNoteData('<?php echo $CONFIG['ajax_secret'] ?>')">Show</a>

                </div>

            </div>

            <div class="boxedcontent">
                <div class="bc_header">Highscores</div>

                <div class="bc_data keyvaluelist kvl_300">

                    <?php foreach (Highscores::getAllGames() as $game): ?>

                        <div><span><?php echo '[' . $game['NAME'] . '] Entries:' ?></span> <span><a href="/Highscores/list?gameid=<?php echo $game['ID']; ?>"><?php echo Highscores::getEntryCountFromGame($game['ID']); ?></a></span></div>
                        <div><span><?php echo '[' . $game['NAME'] . '] Highscore:' ?></span> <span><?php
                                $hs = Highscores::getOrderedEntriesFromGame($game['ID'], 1)[0];
                                echo $hs['POINTS'] . ' (' . $hs['PLAYER'] . ') @ ' . $hs['TIMESTAMP'];
                                ?></span></div>
                        <div><span><?php echo '[' . $game['NAME'] . '] Last Update:' ?></span> <span><?php echo Highscores::getNewestEntriesFromGame($game['ID'], 1)[0]['TIMESTAMP']; ?></span></div>

                        <hr />

                    <?php endforeach; ?>

                </div>

            </div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>