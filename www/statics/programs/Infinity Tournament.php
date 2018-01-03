<?php

return 
[
	'name'              => 'Infinity Tournament',
	'category'          => 'Game',
	'stars'             => 4,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A never ending Tower Defense where you fight against your own score.',
	'add_date'          => '2012-04-14',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Infinity Tournament_description.md'); },
	'thumbnail_name'    => 'Infinity Tournament.png',
];
