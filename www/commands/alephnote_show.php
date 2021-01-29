<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

?>
<div class="stripedtable_container">
	<table class="stripedtable">
		<thead>
			<tr>
				<?php if ($mode == 'short'): ?>
                    <th>Version</th>
                    <th>Provider</th>
                    <th>NoteCount</th>
                    <th>LastChanged</th>
                    <th>CreatedAt</th>
                    <th>Comment</th>
				<?php elseif ($mode == 'full'): ?>
                    <th>ClientID</th>
                    <th>Version</th>
                    <th>Provider</th>
                    <th>NoteCount</th>
                    <th>LastChanged</th>
                    <th>CreatedAt</th>
                    <th>Comment</th>
                    <th>RawFolderRepo</th>
                    <th>RawFolderRepoMode</th>
                    <th>GitMirror</th>
                    <th>GitMirrorPush</th>
                    <th>Theme</th>
                    <th>LaunchOnBoot</th>
                    <th>EmulateHierarchicalStructure</th>
                    <th>HasEditedAdvancedSettings</th>
                    <th>AdvancedSettingsDiff</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($SITE->modules->AlephNoteStatistics()->getAllActiveEntriesOrdered() as $entry): ?>
				<tr>
					<?php if ($mode == 'short'): ?>
                        <td><?php echo $entry['Version']; ?></td>
                        <td><?php echo $entry['ProviderStr']; ?></td>
                        <td><?php echo $entry['NoteCount']; ?></td>
                        <td><?php echo $entry['LastChanged']; ?></td>
                        <td><?php echo $entry['CreatedAt']; ?></td>
                        <td><?php echo $entry['Comment']; ?></td>
					<?php elseif ($mode == 'full'): ?>
                        <td><?php echo $entry['ClientID']; ?></td>
                        <td><?php echo $entry['Version']; ?></td>
                        <td><?php echo $entry['ProviderStr']; ?></td>
                        <td><?php echo $entry['NoteCount']; ?></td>
                        <td><?php echo $entry['LastChanged']; ?></td>
                        <td><?php echo $entry['CreatedAt']; ?></td>
                        <td><?php echo $entry['Comment']; ?></td>
                        <td><?php echo $entry['RawFolderRepo']; ?></td>
                        <td><?php echo $entry['RawFolderRepoMode']; ?></td>
                        <td><?php echo $entry['GitMirror']; ?></td>
                        <td><?php echo $entry['GitMirrorPush']; ?></td>
                        <td><?php echo $entry['Theme']; ?></td>
                        <td><?php echo $entry['LaunchOnBoot']; ?></td>
                        <td><?php echo $entry['EmulateHierarchicalStructure']; ?></td>
                        <td><?php echo $entry['HasEditedAdvancedSettings']; ?></td>
                        <td><?php echo $entry['AdvancedSettingsDiff']; ?></td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>