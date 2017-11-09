<?php

return 
[
	'name'              => 'BefunZ',
	'category'          => 'Interpreter',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'C#',
	'short_description' => 'A Befunge-93 Interpreter compatible with Befunge-98 dimensions.',
	'add_date'          => '2013-05-03',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/BefunZ_description.md'); },
	'thumbnail_url'     => 'BefunZ.png',
];
