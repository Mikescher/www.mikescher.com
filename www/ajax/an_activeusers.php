<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/database.php');
require_once (__DIR__ . '/../internals/alephnoteStatistics.php');

Database::connect();

?>
<div class="stripedtable_container">
	<table class="stripedtable">
		<thead>
			<tr>
				<th>ClientID</th>
				<th>Version</th>
				<th>Provider</th>
				<th>NoteCount</th>
				<th>LastChanged</th>
				<th>CreatedAt</th>
				<th>Comment</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach (AlephNoteStatistics::getAllActiveEntriesOrdered() as $entry): ?>
				<tr>
					<td><?php echo $entry['ClientID']; ?></td>
					<td><?php echo $entry['Version']; ?></td>
					<td><?php echo $entry['ProviderStr']; ?></td>
					<td><?php echo $entry['NoteCount']; ?></td>
					<td><?php echo $entry['LastChanged']; ?></td>
					<td><?php echo $entry['CreatedAt']; ?></td>
					<td><?php echo $entry['Comment']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>