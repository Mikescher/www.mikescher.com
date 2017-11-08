<?php

return 
[
	'name'              => 'exeExtract',
	'category'          => 'Tool',
	'stars'             => 0,
	'ui_language'       => 'English',
	'prog_language'     => 'Delphi',
	'short_description' => 'A simple tool to copy all files of a specific extension from a folder.',
	'add_date'          => '2008-03-26',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/exeExtract_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/exeExtract.png',
];
