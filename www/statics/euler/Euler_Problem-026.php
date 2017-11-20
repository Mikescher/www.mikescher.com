<?php

return 
[
	'number'      => 26,
	'title'       => 'Reciprocal cycles',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-026_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-026.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-026_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=026',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-026.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 21266126,
	'time'        => 4477,
	'width'       => 100,
	'height'      => 16,
	'value'       => 983,
];
