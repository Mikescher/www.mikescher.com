<?php

return 
[
	'name'              => 'Logistixx',
	'category'          => 'Mathematics',
	'stars'             => 1,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Find the trick to escape the seemingly escape-proof maze.',
	'add_date'          => '2008-12-20',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Logistixx_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Logistixx.png',
];
