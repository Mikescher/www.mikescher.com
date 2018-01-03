<?php

return 
[
	'name'              => 'Ziegenproblem',
	'category'          => 'Mathematics',
	'stars'             => 0,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Simulate the popular Monty Hall problem (ger: Ziegenproblem) with this program for yourself.',
	'add_date'          => '2008-04-10',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Ziegenproblem_description.md'); },
	'thumbnail_name'    => 'Ziegenproblem.png',
];
