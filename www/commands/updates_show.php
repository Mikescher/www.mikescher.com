<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');
require_once (__DIR__ . '/../internals/updateslog.php');

Database::connect();

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
			<?php foreach (UpdatesLog::getEntries($_GET['ulname'], 512) as $entry): ?>
				<tr>
					<td><?php echo $entry['ip']; ?></td>
					<td><?php echo $entry['version']; ?></td>
					<td><?php echo $entry['date']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>