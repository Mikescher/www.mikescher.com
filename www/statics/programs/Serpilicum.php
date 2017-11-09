<?php

return 
[
	'name'              => 'Serpilicum',
	'category'          => 'Game',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'C++',
	'short_description' => 'A crazy little Snake with an \"Console\" Style',
	'add_date'          => '2013-07-08',
	'urls'              =>
	[
		'download'    => 'direkt',
		'github'      => 'https://github.com/Mikescher/Serpilicum',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Serpilicum_description.md'); },
	'thumbnail_url'     => 'Serpilicum.png',
];
