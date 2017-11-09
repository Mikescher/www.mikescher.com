<?php

return 
[
	'name'              => 'HexSolver',
	'category'          => 'Tool',
	'stars'             => 5,
	'ui_language'       => 'English',
	'prog_language'     => 'C#',
	'short_description' => 'An automatic parser and solver for Hexcells, Hexcells Plus and Hexcells Infinite." +
    "',
	'add_date'          => '2015-05-06',
	'urls'              =>
	[
		'github'      => 'https://github.com/Mikescher/HexSolver',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/HexSolver_description.md'); },
	'thumbnail_url'     => 'HexSolver.png',
];
