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

$FRAME_OPTIONS->addScript('https://code.jquery.com/jquery-latest.min.js', true);
$FRAME_OPTIONS->addScript('/data/javascript/admin.js', true);


$connected = true; try { $SITE->modules->Database(); } catch (Exception $e) { $connected = false; }

$rok = ['result'=>'ok','message'=>''];

$consistency_blog    = $rok; try { $consistency_blog    = $SITE->modules->Blog()->checkConsistency();              } catch (Exception $e) { $consistency_blog    = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_prog    = $rok; try { $consistency_prog    = $SITE->modules->Programs()->checkConsistency();          } catch (Exception $e) { $consistency_prog    = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_euler   = $rok; try { $consistency_euler   = $SITE->modules->Euler()->checkConsistency();             } catch (Exception $e) { $consistency_euler   = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_books   = $rok; try { $consistency_books   = $SITE->modules->Books()->checkConsistency();             } catch (Exception $e) { $consistency_books   = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_egg     = $rok; try { $consistency_egg     = $SITE->modules->ExtendedGitGraph()->checkConsistency();  } catch (Exception $e) { $consistency_egg     = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_progimg = $rok; try { $consistency_progimg = $SITE->modules->Programs()->checkThumbnails();           } catch (Exception $e) { $consistency_progimg = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_bookimg = $rok; try { $consistency_bookimg = $SITE->modules->Books()->checkThumbnails();              } catch (Exception $e) { $consistency_bookimg = ['result'=>'ok', 'message'=>"$e"]; }
$consistency_aoc     = $rok; try { $consistency_aoc     = $SITE->modules->AdventOfCode()->checkConsistency();      } catch (Exception $e) { $consistency_aoc     = ['result'=>'ok', 'message'=>"$e"]; }

function dumpConsistency($c)
{
	if ($c['result']==='ok') echo "<span class='consistency_result_ok'>OK</span>";
	else if ($c['result']==='warn') echo "<span class='consistency_result_warn'>".$c['message']."</span>";
	else echo "<span class='consistency_result_err'>".$c['message']."</span>";
}

?>

<div class="admincontent">

    <div class="contentheader"><h1>Admin</h1><hr/></div>

	<?php if (!$connected): ?>
        <div class="boxedcontent alertbox">
            <div class="bc_data">Could not connect to database</div>
        </div>
	<?php endif; ?>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Version</div>

        <div class="bc_data keyvaluelist kvl_100">
            <div><span>Branch:</span> <span><?php echo exec('git rev-parse --abbrev-ref HEAD'); ?></span></div>
            <div><span>Commit:</span> <span><?php echo exec('git rev-parse HEAD'); ?></span></div>
            <div><span>Date:</span>   <span><?php echo exec('git log -1 --format=%cd'); ?></span></div>
            <div><span>Message:</span><span><?php echo nl2br(trim(exec('git log -1'))); ?></span></div>
        </div>
    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Self test</div>

        <div class="bc_data">
            <div class="keyvaluelist kvl_200">
                <div><span>Program thumbnails:</span> <?php dumpConsistency($consistency_progimg); ?></div>
                <div><span>ExtendedGitGraph:</span>   <?php dumpConsistency($consistency_egg);     ?></div>
                <div><span>Book thumbnails:</span>    <?php dumpConsistency($consistency_bookimg); ?></div>
                <div><span>Blog data:</span>          <?php dumpConsistency($consistency_blog);    ?></div>
                <div><span>Euler data:</span>         <?php dumpConsistency($consistency_euler);   ?></div>
                <div><span>AdventOfCode data:</span>  <?php dumpConsistency($consistency_aoc);     ?></div>
                <div><span>Programs data:</span>      <?php dumpConsistency($consistency_prog);    ?></div>
                <div><span>Books data:</span>         <?php dumpConsistency($consistency_books);   ?></div>
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

        <div class="bc_data keyvaluelist kvl_200">
            <div><span>Registered IP:</span> <span><?php echo $self_ip; ?></span></div>
            <div><span>Current IP:</span> <span><?php echo $real_ip; ?></span></div>
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
                <div class="keyvaluelist kvl_200">
                    <div><span>Total users:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getTotalUserCount(); ?></span></div>
                    <div><span>Users on latest version:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getUserCountFromLastVersion(); ?></span></div>
                    <div><span>Active users:</span> <span><?php echo $SITE->modules->AlephNoteStatistics()->getActiveUserCount(32); ?></span></div>
                </div>
                <br/>
                <div id="an_ajax_target"></div>
                <a class="button" href="javascript:startAjaxReplace('#an_ajax_target', '/api/alephnote::show?secret=<?php echo $SITE->config['ajax_secret'] ?>')">Show</a>
            </div>
		<?php else: ?>
            <div class="bc_data keyvaluelist admindberr">Database not connected.</div>
		<?php endif; ?>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Statics</div>

        <div class="bc_data keyvaluelist kvl_200">
            <div><span>Blog entries:</span> <span><?php    echo count($SITE->modules->Blog()->listAll()); ?></span></div>
            <div><span>Book entries:</span> <span><?php    echo count($SITE->modules->Books()->listAll()); ?></span></div>
            <div><span>Euler entries:</span> <span><?php   echo count($SITE->modules->Euler()->listAll()); ?></span></div>
            <div><span>Program entries:</span> <span><?php echo count($SITE->modules->Programs()->listAll()); ?></span></div>
            <div><span>Update entries:</span> <span><?php  echo count($SITE->modules->UpdatesLog()->listUpdateData()); ?></span></div>
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
        <div class="bc_data keyvaluelist kvl_200">
			<?php
			foreach ($SITE->config as $key => $value)
			{
				if ($key === 'extendedgitgraph') continue;

				if (is_array($value))
					echo '<div><span>' . $key . '</span> <span style="white-space: pre">' . json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</span></div>' . "\n";
				else
					echo '<div><span>' . $key . '</span> <span>' . nl2br(var_export($value, true)) . '</span></div>' . "\n";
			}
			?>
        </div>
    </div>

    <div class="boxedcontent">
        <div class="bc_header">Configuration['extendedgitgraph']</div>
        <div class="bc_data keyvaluelist kvl_200">
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
