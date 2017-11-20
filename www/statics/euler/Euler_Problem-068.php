<?php

return 
[
	'number'      => 68,
	'title'       => 'Magic 5-gon ring',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-068_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-068.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-068_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=068',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-068.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 304112,
	'time'        => 78,
	'width'       => 39,
	'height'      => 25,
	'value'       => 6531031914842725,
];
