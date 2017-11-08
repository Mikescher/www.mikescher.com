<?php

return 
[
	'name'              => 'jClipCorn',
	'category'          => 'Tool',
	'stars'             => 4,
	'ui_language'       => 'English|German',
	'prog_language'     => 'Java',
	'short_description' => 'Organize your movies and series on an external hard drive.',
	'add_date'          => '2012-10-28',
	'urls'              =>
	[
		'download'    => 'https://github.com/Mikescher/jClipCorn/releases',
		'github'      => 'https://github.com/Mikescher/jClipCorn/',
		'wiki'        => 'https://github.com/Mikescher/jClipCorn/wiki',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/jClipCorn_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/jClipCorn.png',
];
