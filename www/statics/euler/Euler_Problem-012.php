<?php

return 
[
	'number'      => 12,
	'title'       => 'Highly divisible triangular number',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-012_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-012.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-012_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=012',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-012.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 38855123,
	'time'        => 7566,
	'width'       => 1000,
	'height'      => 170,
	'value'       => 76576500,
];
