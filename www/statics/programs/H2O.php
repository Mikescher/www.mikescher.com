<?php

return 
[
	'name'              => 'H2O',
	'category'          => 'Game',
	'stars'             => 2,
	'ui_language'       => 'English',
	'prog_language'     => 'Delphi',
	'short_description' => 'Try creating the biggest chain reaction and see yourself climb up in the global l" +
    "eaderboard.',
	'add_date'          => '2009-01-24',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/H2O_description.md'); },
	'thumbnail_url'     => 'H2O.png',
];
