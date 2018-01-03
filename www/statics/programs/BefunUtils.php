<?php

return 
[
	'name'              => 'BefunUtils',
	'category'          => 'Compiler',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'C#',
	'short_description' => 'My selfmade Code-to-Befunge93 compiler, with a few little extras.',
	'add_date'          => '2014-08-04',
	'urls'              =>
	[
		'github'      => 'https://github.com/Mikescher/BefunUtils',
		'wiki'        => 'https://github.com/Mikescher/BefunUtils/wiki',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/BefunUtils_description.md'); },
	'thumbnail_name'    => 'BefunUtils.png',
];
