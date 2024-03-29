<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Admin';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/admin';
$FRAME_OPTIONS->activeHeader = 'admin';

$FRAME_OPTIONS->addScript('https://code.jquery.com/jquery-latest.min.js', false);
$FRAME_OPTIONS->addScript('/data/javascript/admin.js', false);


$connected = true; try { $SITE->modules->Database(); } catch (Exception $e) { $connected = false; }

?>

<div class="admincontent">

    <div class="contentheader"><h1>Admin</h1><hr/></div>

	<?php if (!$connected): ?>
        <div class="boxedcontent alertbox">
            <div class="bc_data">Could not connect to database</div>
        </div>
	<?php endif; ?>

	<?php if (!$SITE->isProd()): ?>
        <div class="boxedcontent warnbox">
            <div class="bc_data">Website runs in /dev/ mode</div>
        </div>
	<?php endif; ?>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Version</div>

        <div class="bc_data keyvaluelist kvl_100">
            <div><span>Branch:</span> <span class="admin_ajax_gitfield" data-ajax_gitfield="branch"   >...</span></div>
            <div><span>Commit:</span> <span class="admin_ajax_gitfield" data-ajax_gitfield="head"     >...</span></div>
            <div><span>Date:</span>   <span class="admin_ajax_gitfield" data-ajax_gitfield="timestamp">...</span></div>
            <div><span>Origin:</span> <span class="admin_ajax_gitfield" data-ajax_gitfield="origin"   >...</span></div>
            <div><span>Message:</span><span class="admin_ajax_gitfield" data-ajax_gitfield="message"  >...</span></div>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Self test</div>

        <div class="bc_data">
            <a id="btnFullSelftest" class="button" href="#">Full Selftest</a>

            <div class="keyvaluelist kvl_250 selftest_parent <?= ($SITE->isProd() ? 'selftest_parallel' : 'selftest_sequential') ?>">
                <?php $stid=1000; foreach ($SITE->modules->SelfTest()->listMethodGroups() as $group): $stid++; ?>
                    <div class="selftest_tabchild" onclick="showSelfTestOutput('#selftest_tab_<?= $stid; ?>', '#selftest_out_<?= $stid; ?>')">
                        <span><?= $group['name']; ?></span>
                        <span class='consistency_result consistency_result_intermed consistence_ajax_handler' id="selftest_tab_<?= $stid; ?>" data-filter="<?= $group['filter']; ?>" data-stid="#selftest_out_<?= $stid; ?>" data-root="<?= $group['root'] ?>"></span>
                    </div>
                    <div class="selftest_outputchild generic_nodisplay" id="selftest_out_<?= $stid; ?>">&nbsp;</div>
                <?php endforeach; ?>
            </div>
            <br/>
            <a class="button" href="/api/site::createProgramThumbnails">Update Program Thumbnails</a>
            <a class="button" href="/api/site::createBookThumbnails">Update Book Thumbnails</a>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Self IP Addr</div>

		<?php
		$ippath = __DIR__ . '/../dynamic/self_ip_address.auto.cfg';
		$self_ip = file_exists($ippath) ? file_get_contents($ippath) : 'N/A';
		$real_ip = get_client_ip();
		$me = $real_ip == $self_ip
		?>

        <div class="bc_data keyvaluelist kvl_250">
            <div><span>Registered IP:</span> <span><?php echo $self_ip; ?></span></div>
            <div><span>Current IP:</span> <span><?php echo $real_ip; ?></span></div>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Project Lawful ebook (download count)</div>

        <div class="bc_data keyvaluelist kvl_250">
            <?php if ($connected): ?>
                <?php foreach ($SITE->modules->ProjectLawful()->listDownloadCountsExt() as $variant => [$nonbot, $total, $ts]): ?>
                    <div class="row_hover">
                        <span><?php echo $variant; ?>:</span>
                        &nbsp;
                        <span title="non-crawler count" style="min-width: 4em"><?php echo $nonbot; ?></span>
                        &nbsp;
                        <span title="total count" style="opacity: 0.45; min-width: 6em;">( <?php echo $total; ?> )</span>
                        &nbsp;
                        <span title="last-non-crawler-download" style="opacity: 0.75"><?php echo $ts; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bc_data keyvaluelist admindberr">Database not connected.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">ExtendedGitGraph</div>

        <div class="bc_data">

            <textarea class="egg_ajaxOutput" id="egg_ajaxOutput" readonly="readonly"></textarea>
            <a class="button" href="javascript:startAjaxRefresh('<?php echo $SITE->config['ajax_secret'] ?>')">Update</a>
            <a class="button" href="javascript:startAjaxRedraw('<?php echo $SITE->config['ajax_secret'] ?>')">Redraw</a>

        </div>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">AlephNote</div>

		<?php if ($connected): ?>
            <div class="bc_data">
                <div class="keyvaluelist kvl_250">
                    <div><span>Total users:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getTotalUserCount(); ?></span></div>
                    <div><span>Users on latest version:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getUserCountFromLastVersion(); ?></span></div>
                    <div><span>Active users:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getActiveUserCount(32); ?></span></div>
                </div>
                <br/>
                <div id="an_ajax_target"></div>
                <a class="button" href="javascript:startAjaxReplace('#an_ajax_target', '/api/alephnote::show?secret=<?php echo $SITE->config['ajax_secret'] ?>&mode=short')">Show (short)</a>
                <a class="button" href="javascript:startAjaxReplace('#an_ajax_target', '/api/alephnote::show?secret=<?php echo $SITE->config['ajax_secret'] ?>&mode=full')" >Show (full)</a>
            </div>
		<?php else: ?>
            <div class="bc_data keyvaluelist admindberr">Database not connected.</div>
		<?php endif; ?>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Statics</div>

        <div class="bc_data keyvaluelist kvl_250">
            <div class="row_hover" ><span>Blog entries:</span> <span><?php    echo count($SITE->modules->Blog()->listAll()); ?></span></div>
            <div class="row_hover" ><span>Book entries:</span> <span><?php    echo count($SITE->modules->Books()->listAll()); ?></span></div>
            <div class="row_hover" ><span>Euler entries:</span> <span><?php   echo count($SITE->modules->Euler()->listAll()); ?></span></div>
            <div class="row_hover" ><span>Program entries:</span> <span><?php echo count($SITE->modules->Programs()->listAll()); ?></span></div>
            <div class="row_hover" ><span>Update entries:</span> <span><?php  echo count($SITE->modules->UpdatesLog()->listUpdateData()); ?></span></div>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">UpdatesLog</div>

		<?php if ($connected): ?>
            <div class="bc_data keyvaluelist kvl_300">
				<?php foreach ($SITE->modules->UpdatesLog()->listProgramsInformation() as $info): ?>
                    <div><span><?php echo '[' . $info['name'] . '] Count:' ?></span> <span><a href="javascript:startAjaxReplace('#ul_ajax_target', '/api/updates::show?secret=<?php echo $SITE->config['ajax_secret'] ?>&ulname=<?php echo $info['name'] ?>')"><?php echo $info['count_total']; ?></a></span></div>
                    <div><span><?php echo '[' . $info['name'] . '] Last query:' ?></span> <span><?php echo $info['last_query']; ?></span></div>
                    <div><span><?php echo '[' . $info['name'] . '] Count (1 week):' ?></span> <span><?php echo $info['count_week']; ?></span></div>
                    <hr />
				<?php endforeach; ?>
                <br/>
                <div id="ul_ajax_target"></div>
            </div>
		<?php else: ?>
            <div class="bc_data keyvaluelist admindberr">Database not connected.</div>
		<?php endif; ?>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Highscores</div>

		<?php if ($connected): ?>
            <div class="bc_data keyvaluelist kvl_300">

				<?php foreach ($SITE->modules->Highscores()->getAllGames() as $game): ?>

                    <div><span><?php echo '[' . $game['NAME'] . '] Entries:' ?></span> <span><a href="/highscores/list?gameid=<?php echo $game['ID']; ?>"><?php echo $SITE->modules->Highscores()->getEntryCountFromGame($game['ID']); ?></a></span></div>
                    <div><span><?php echo '[' . $game['NAME'] . '] Highscore:' ?></span> <span><?php
							$hs = $SITE->modules->Highscores()->getOrderedEntriesFromGame($game['ID'], 1)[0];
							echo $hs['POINTS'] . ' (' . $hs['PLAYER'] . ') @ ' . $hs['TIMESTAMP'];
							?></span></div>
                    <div><span><?php echo '[' . $game['NAME'] . '] Last Update:' ?></span> <span><?php echo $SITE->modules->Highscores()->getNewestEntriesFromGame($game['ID'], 1)[0]['TIMESTAMP']; ?></span></div>

                    <hr />

				<?php endforeach; ?>

            </div>
		<?php else: ?>
            <div class="bc_data keyvaluelist admindberr">Database not connected.</div>
		<?php endif; ?>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Configuration</div>
        <div class="bc_data keyvaluelist kvl_250">
			<?php
			foreach ($SITE->config as $key => $value)
			{
				if ($key === 'extendedgitgraph') continue;

				if (is_array($value))
					echo '<div class="row_hover"><span>' . $key . '</span> <span style="white-space: pre">' . json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</span></div>' . "\n";
				else
					echo '<div class="row_hover"><span>' . $key . '</span> <span>' . nl2br(var_export($value, true)) . '</span></div>' . "\n";
			}
			?>
        </div>
    </div>

    <div class="boxedcontent">
        <div class="bc_header">Configuration['extendedgitgraph']</div>
        <div class="bc_data keyvaluelist kvl_250">
			<?php
			foreach ($SITE->config['extendedgitgraph'] as $key => $value)
			{
				if (is_array($value))
					echo '<div><span>' . $key . '</span> <span style="white-space: pre">' . json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</span></div>' . "\n";
				else
					echo '<div><span>' . $key . '</span> <span>' . nl2br(var_export($value, true)) . '</span></div>' . "\n";
			}
			?>
        </div>
    </div>

</div>
