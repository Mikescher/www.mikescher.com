<?php

return 
[
	'name'              => 'Crystal Grid',
	'category'          => 'Game',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A challenging, tactical mini-game in blueprint-style.',
	'add_date'          => '2013-01-03',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Crystal Grid_description.md'); },
	'thumbnail_url'     => 'Crystal Grid.png',
];
