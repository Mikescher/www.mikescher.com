<?php
/* @var $year integer */
/* @var ymap integer[] */
/* @var $ymapmax integer */
?>

<?php

$DIST_X = 13;
$DIST_Y = 13;
$DAY_WIDTH = 11;
$DAY_HEIGHT = 11;


$COLORS = ['#F5F5F5', '#DBDEE0', '#C2C7CB', '#AAB0B7', '#9099A2', '#77828E', '#5E6B79', '#455464', '#2C3E50'];
$MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$DAYS = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

?>

<?php

$date = new DateTime($year . '-01-01');

$monthlist = array_fill(0, 12, [0, 0]);

?>
<div class="extGitGraphContainer">
	<svg class="git_list">
		<g transform="translate(20, 20) ">
			<g transform="translate(0, 0)">
				<?php
					$now = new DateTime();
					$exponent = log(0.98/(count($COLORS)-1), 1/$ymapmax); // (1/max)^n = 0.98   // => 1 commit erreicht immer genau die erste stufe

					$week = 0;
					while($date->format('Y') == $year) {
						if ($date > new DateTime()) {// THE FUTURE, SPONGEBOB
							while ($date->format('d') != $date->format('t')) {
								if ($date->format('N') == 1 && $date->format('z') > 0) {
									$week++;
								}
								$date = $date->modify("+1 day");
							}
							$monthlist[$date->format('m') - 1][1] = $week + ($wday / 7);

							$date = $date->modify("+1 year"); // Kill
							continue;
						}

						$c_count = $ymap[$date->format('Y-m-d')];
						$color_idx = min((count($COLORS)-1), ceil(pow($c_count/$ymapmax, $exponent) * (count($COLORS)-1)));
						$color = $COLORS[$color_idx];

						$wday = ($date->format('N') - 1);

						if ($date->format('N') == 1 && $date->format('z') > 0) {
							echo '</g>', PHP_EOL;
							$week++;
							echo '<g transform="translate(' . $week*$DIST_X . ', 0)">', PHP_EOL;
						}

						if ($date->format('d') == 1) {
							$monthlist[$date->format('m') - 1][0] = $week + ($wday / 7);
						} else if ($date->format('d') == $date->format('t')) {
							$monthlist[$date->format('m') - 1][1] = $week + ($wday / 7);
						}

						echo '<rect style="fill: ' . $color .
							';" y="' . $wday*$DIST_Y .
							'" height="' . $DAY_HEIGHT .
							'" width="' . $DAY_WIDTH .
							'" dbg_tag="' . $date->format('d.m.Y') . ' [' . $year . ' :: '.$week.' :: '.$wday.'] -> ' . $color_idx .
							'" hvr_header="' . $c_count . ' commits'.
							'" hvr_content="' . ' ' . $date->format('\o\n l jS F Y') .
							'"/>', PHP_EOL;

						$date = $date->modify("+1 day");
					}
				?>
			</g>

			<?php

			for($i = 0; $i < 12; $i++) {
				if ($monthlist[$i][1]-$monthlist[$i][0] > 0) {
					$posx = (($monthlist[$i][0]+$monthlist[$i][1])/2) * $DIST_X;
					echo '<text y="-3" x="' . $posx . '" style="text-anchor: middle" class="caption_month">' . $MONTHS[$i] . '</text>';
				}
			}

			for($i = 0; $i < 7; $i++) {
				echo '<text y="' . ($i*$DIST_Y + $DAY_HEIGHT/2) . '" x="-6" style="text-anchor: middle" class="caption_day" dominant-baseline="central">' . $DAYS[$i] . '</text>';
			}

			echo '<text  x="-10" y="-5" class="caption">' . $year . '</text>';

			?>
		</g>
	</svg>

	<div class="svg-tip n">
		<strong>&nbsp;</strong><span>&nbsp;</span>
	</div>

	<div class="egg_footer">
		<a href="/programs/view/ExtendedGitGraph">extendedGitGraph</a>
	</div>
</div>