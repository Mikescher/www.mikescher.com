<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

global $FRAGMENT_PARAM;
/** @var array $parameter */
$parameter = $FRAGMENT_PARAM;
?>

<?php
$post = $parameter['blogpost'];
$subview = $parameter['subview'];

$euler   = $SITE->modules->Euler()->listAll();
$problem = $SITE->modules->Euler()->getEulerProblemFromStrIdent($subview);

if ($problem === NULL) { $FRAME_OPTIONS->forceResult(404, 'Project Euler entry not found'); return; }

$arr = [];
$max = 0;
foreach ($euler as $elem)
{
	$max = max($max, $elem['number']);
	$arr[$elem['number']] = $elem;
}
$max = ceil($max / 20) * 20;

?>

<div class="boxedcontent blogcontent_euler base_markdown">

    <div style="position: relative;">
        <a href="https://github.com/Mikescher/Project-Euler_Befunge" style="position: absolute; top: 0; right: 0; border: 0;">
            <img src="/data/images/blog/github_band.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
        </a>
    </div>

	<div class="bc_header">
		<?php echo $problem['date']; ?>
	</div>

	<div class="bc_data">

        <div class="bce_header"><h1><a href="<?php echo $problem['url_euler']; ?>">Problem <?php echo $problem['number3']; ?></a>: <?php echo htmlspecialchars($problem['title']); ?></h1></div>

        <b>Description:</b>
        <div class="bce_description"><?php echo $SITE->renderMarkdown(file_get_contents($problem['file_description'])); ?></div>
        <br/>

        <b>Solution:</b>
		<?php
            echo $SITE->fragments->WidgetBefunge93(file_get_contents($problem['file_code']), $problem['url_raw'], !$problem['abbreviated'], $problem['steps'] < 15000 ? 1 : ($problem['steps'] < 500000 ? 2 : 3), false);

            if ($problem['abbreviated']) echo '<i>This program is too big to display/execute here, click [download] to get the full program. </i><br/>';
		?>
        <br/>

        <b>Explanation:</b>
        <div class="bce_explanation"><?php echo $SITE->renderMarkdown(file_get_contents($problem['file_explanation'])); ?></div>
        <br/>

        <table class="notable">
            <tr>
                <td><b>Interpreter steps:</b></td>
                <td><?php echo number_format($problem['steps'], 0, null, ' '); ?></td>
            </tr>
            <tr>
                <td><b>Execution time</b> (<a href="/programs/view/BefunUtils">BefunExec</a>):</td>
                <td><?php echo formatMilliseconds($problem['time']) . ' <i>(' . (($problem['time']===0) ? '?' : number_format(($problem['steps']/$problem['time'])/1000, 2, '.', '')) . ' MHz)</i>'; ?></td>
            </tr>
            <tr>
                <td><b>Program size:</b></td>
                <td><?php echo $problem['width'] . ' x ' . $problem['height']; if ($problem['is93']) echo '<i> (fully conform befunge-93)</i>'; ?></td>
            </tr>
            <tr>
                <td><b>Solution:</b></td>
                <td><?php echo $problem['value']; ?></td>
            </tr>
            <tr>
                <td><b>Solved at:</b></td>
                <td><?php echo $problem['date']; ?></td>
            </tr>
        </table>

        <br />
        <br />

        <div class="pagination">

            <?php
                $break = false;
                for($i1=0;;$i1++)
                {
                    echo "<div class='pag20'>\n";
					for($i2=0;$i2<2;$i2++)
					{
						echo "<div class='pag10'>\n";
						for($i3=0;$i3<2;$i3++)
						{
							echo "<div class='pag05'>\n";
							for($i4=0;$i4<5;$i4++)
							{
                                $ii = $i1*20 + $i2*10 + $i3*5 + $i4 + 1;
								if ($ii > $max) {$break = true; break;}

                                $pii = str_pad($ii, 3, '0', STR_PAD_LEFT);

								if ($ii == $problem['number'])
									echo "<div class='pagbtn pagbtn_active'>" . $pii . "</div>\n";
								else if (key_exists($ii, $arr))
                                    echo "<a class='pagbtn' href='/blog/1/Project_Euler_with_Befunge/problem-" . $pii . "'>" . $pii . "</a>\n";
                                else
									echo "<div class='pagbtn pagbtn_disabled'>" . $pii . "</div>\n";
							}
							echo "</div>\n";
							if ($break) break;
						}
						echo "</div>\n";
						if ($break) break;
					}
					echo "</div>\n";
					if ($break) break;
                }
            ?>

        </div>

	</div>
</div>