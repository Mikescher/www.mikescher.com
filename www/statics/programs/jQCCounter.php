<?php

return 
[
	'name'              => 'jQCCounter',
	'category'          => 'Tool',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A little tool to find the \"line of codes\" of multiple projects',
	'add_date'          => '2014-04-27',
	'urls'              =>
	[
		'github'      => 'https://github.com/Mikescher/jQCCounter',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/jQCCounter_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/jQCCounter.png',
];
