<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/highscores.php');
require_once (__DIR__ . '/../internals/alephnoteStatistics.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/euler.php');
require_once (__DIR__ . '/../internals/highscores.php');
require_once (__DIR__ . '/../internals/mikeschergitgraph.php');
require_once (__DIR__ . '/../internals/programs.php');
require_once (__DIR__ . '/../internals/books.php');

Database::connect();

$consistency_blog    = Blog::checkConsistency();
$consistency_prog    = Programs::checkConsistency();
$consistency_euler   = Euler::checkConsistency();
$consistency_books   = Books::checkConsistency();
$consistency_egh     = MikescherGitGraph::checkConsistency();
$consistency_progimg = Programs::checkThumbnails();
$consistency_bookimg = Books::checkThumbnails();

?>
<?php

function dumpConsistency($c) {
	if ($c['result']==='ok') echo "<span class='consistency_result_ok'>OK</span>";
	else if ($c['result']==='warn') echo "<span class='consistency_result_warn'>".$c['message']."</span>";
	else echo "<span class='consistency_result_err'>".$c['message']."</span>";
}

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Admin</title>
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
                <div class="bc_header">Self test</div>

                <div class="bc_data">
                    <div class="keyvaluelist kvl_200">
                        <div><span>Program thumbnails:</span> <?php dumpConsistency($consistency_progimg); ?></div>
                        <div><span>ExtendedGitGraph:</span>   <?php dumpConsistency($consistency_egh);     ?></div>
                        <div><span>Book thumbnails:</span>    <?php dumpConsistency($consistency_bookimg); ?></div>
                        <div><span>Blog data:</span>          <?php dumpConsistency($consistency_blog);    ?></div>
                        <div><span>Euler data:</span>         <?php dumpConsistency($consistency_euler);   ?></div>
                        <div><span>Programs data:</span>      <?php dumpConsistency($consistency_prog);    ?></div>
                        <div><span>Books data:</span>         <?php dumpConsistency($consistency_books);   ?></div>
                    </div>
                    <br/>
                    <a class="button" href="/admin/cmd/createProgramThumbnails">Update Program Thumbnails</a>
                    <a class="button" href="/admin/cmd/createBookThumbnails">Update Book Thumbnails</a>

                </div>
            </div>

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">Self IP Addr</div>

                <?php
                $ippath = __DIR__ . '/../dynamic/self_ip_address.auto.cfg';
                $self_ip = file_exists($ippath) ? file_get_contents($ippath) : 'N/A';
                $real_ip = get_client_ip();
                $me = $real_ip == $self_ip
                ?>

                <div class="bc_data keyvaluelist kvl_200">
                    <div><span>Registered IP:</span> <span><?php echo $self_ip; ?></span></div>
                    <div><span>Current IP:</span> <span><?php echo $real_ip; ?></span></div>
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

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">AlephNote</div>

                <div class="bc_data">
                    <div class="keyvaluelist kvl_200">
                        <div><span>Total users:</span> <span><?php echo AlephNoteStatistics::getTotalUserCount(); ?></span></div>
                        <div><span>Users on latest version:</span> <span><?php echo AlephNoteStatistics::getUserCountFromLastVersion(); ?></span></div>
                        <div><span>Active users:</span> <span><?php echo AlephNoteStatistics::getActiveUserCount(32); ?></span></div>
                    </div>
                    <br/>
                    <div id="an_ajax_target"></div>
                    <a class="button" href="javascript:startAjaxReplace('#an_ajax_target', '/su_ajax/alephNoteTable?secret=<?php echo $CONFIG['ajax_secret'] ?>')">Show</a>
                </div>

            </div>

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">Statics</div>

                <div class="bc_data keyvaluelist kvl_200">
                    <div><span>Blog entries:</span> <span><?php    echo count(Blog::listAll()); ?></span></div>
                    <div><span>Book entries:</span> <span><?php    echo count(Books::listAll()); ?></span></div>
                    <div><span>Euler entries:</span> <span><?php   echo count(Euler::listAll()); ?></span></div>
                    <div><span>Program entries:</span> <span><?php echo count(Programs::listAll()); ?></span></div>
                    <div><span>Update entries:</span> <span><?php  echo count(Programs::listUpdateData()); ?></span></div>
                </div>
            </div>

            <!------------------------------------------>

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

            <!------------------------------------------>

            <div class="boxedcontent">
                <div class="bc_header">Configuration</div>

                <div class="bc_data keyvaluelist kvl_200">

					<?php foreach ($CONFIG as $key => $value): ?>
                        <div><span><?php echo $key; ?></span> <span><?php echo var_export($value, true); ?></span></div>
					<?php endforeach; ?>

                </div>

            </div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>