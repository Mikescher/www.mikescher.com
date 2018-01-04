# AlephNote

An extensible, lightweight desktop note client for multiple back-ends

![](https://raw.githubusercontent.com/Mikescher/AlephNote/master/docs/preview.png)  

AlephNote is a lightweight note taking desktop app usable with multiple back-ends:

### Standard Note

With the StandardNotePlugin your notes get synced with a [Standard File server](https://standardnotes.org/).
Your notes are locally encrypted and cannot be read from anyone but you

### Simplenote

With the SimpleNotePlugin you can sync your notes with the free [SimpleNote](https://simplenote.com/) online service

### Nextcloud/owncloud notes

The NextcloudPlugin syncs your notes with the [notes app](https://github.com/nextcloud/notes) running on you own private Nextcloud/Owncloud instance

### Local

You can also simply not use a remote back-end and either use the HeadlessPlugin (don't sync the notes anywhere) or the FilesystemPlugin (sync the notes with another folder).


## Installation

Simply download the latest [release](https://github.com/Mikescher/AlephNote/releases/latest) and extract it where you want (all settings etc are portable).
By default the program automatically searches for new versions and downloads them.
If there is demand for an installer I could make one, but personally I like portable programs more.


## System Requirements

Windows Version:
 - dotNet 4.6 or higher
 - Windows 7 or higher

Linux version
 - TBA

## Special Features

 - Fully featured [scintilla editor](http://www.scintilla.org/) for text display
 - In-editor markdown rendering (similar to [qownnotes](http://www.qownnotes.org/))
 - Interactive highlighting of checkbox lists (e.g. TODO lists)
 - Clickable + highlighted links
 - Drop files/text directly into app to create notes
 - Sort notes into folders
 - Simulate folders for notes with remote provider that do not support folders (path is encoded in filename)
 - Customizable shortcuts
 - Automatic local backup to git repository (and optional pushing to remote repository)

## License

[MIT](https://github.com/Mikescher/AlephNote/blob/master/LICENSE)
