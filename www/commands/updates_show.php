<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>
<div class="stripedtable_container" style="width: 100%;">
	<table class="stripedtable">
		<thead>
			<tr>
				<th>IP</th>
				<th>Version</th>
				<th>Timestamp</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($SITE->modules->UpdatesLog()->getEntries($_GET['ulname'], 512) as $entry): ?>
				<tr>
					<td><?php echo $entry['ip']; ?></td>
					<td><?php echo $entry['version']; ?></td>
					<td><?php echo $entry['date']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>