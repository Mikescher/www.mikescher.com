<?php

return 
[
	'name'              => 'jCircuits',
	'category'          => 'Simulation',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A fully featured logical circuit simulator with many prebuild components',
	'add_date'          => '2011-12-16',
	'urls'              =>
	[
		'download'    => 'direkt',
		'sourceforge' => 'http://sourceforge.net/projects/jcircuits/',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/jCircuits_description.md'); },
	'thumbnail_name'    => 'jCircuits.png',
];
