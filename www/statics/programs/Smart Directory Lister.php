<?php

return 
[
	'name'              => 'Smart Directory Lister',
	'category'          => 'Tool',
	'stars'             => 2,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'List all files in a folder that match a specific pattern and export them in plain" +
    "text.',
	'add_date'          => '2010-01-12',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Smart Directory Lister_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Smart Directory Lister.png',
];
