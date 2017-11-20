<?php

return 
[
	'number'      => 19,
	'title'       => 'Counting Sundays',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-019_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-019.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-019_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=019',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-019.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 3197878,
	'time'        => 546,
	'width'       => 72,
	'height'      => 12,
	'value'       => 171,
];
