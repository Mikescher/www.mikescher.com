<?php

return 
[
	'name'              => 'SuperBitBros',
	'category'          => 'Game',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'C#',
	'short_description' => 'A clone of all original SuperMarioBros (NES) levels, with a few tweaks.',
	'add_date'          => '2013-10-17',
	'urls'              =>
	[
		'download'    => 'direkt',
		'github'      => 'https://github.com/Mikescher/SuperBitBros',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/SuperBitBros_description.md'); },
	'thumbnail_url'     => 'SuperBitBros.png',
];
