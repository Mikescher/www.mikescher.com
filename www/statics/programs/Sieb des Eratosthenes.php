<?php

return 
[
	'name'              => 'Sieb des Eratosthenes',
	'category'          => 'Mathematics',
	'stars'             => 1,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Visualize the prime number calculation with the Sieve of Erastothenes algorithm.',
	'add_date'          => '2009-01-22',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Sieb des Eratosthenes_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Sieb des Eratosthenes.png',
];
