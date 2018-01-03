<?php

return 
[
	'name'              => 'Graveyard of Numbers',
	'category'          => 'Tool',
	'stars'             => 0,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'A little tool to continuously rename files.',
	'add_date'          => '2008-10-01',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Graveyard of Numbers_description.md'); },
	'thumbnail_name'    => 'Graveyard of Numbers.png',
];
