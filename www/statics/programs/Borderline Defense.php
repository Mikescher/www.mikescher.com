<?php

return 
[
	'name'              => 'Borderline Defense',
	'category'          => 'Game',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A improved Space-Invaders clone - programmed from the Java-AG, Oken.',
	'add_date'          => '2012-05-24',
	'urls'              =>
	[
		'download'    => 'direkt',
		'homepage'    => 'http://borderlinedefense.99k.org/',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Borderline Defense_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Borderline Defense.png',
];
