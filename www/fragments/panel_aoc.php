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
$years = $SITE->modules->AdventOfCode()->listYears();
$year = intval(end($years));
?>

<div class="index_pnl_base">

	<div class="index_pnl_header">
        <a href="<?php echo $SITE->modules->AdventOfCode()->getURLForYear($year); ?>">Advent of Code</a>
	</div>
	<div class="index_pnl_content">

		<?php echo $SITE->fragments->PanelAdventOfCodeCalendar($year, true, true, true); ?>

	</div>

</div>