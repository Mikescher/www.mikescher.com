<?php

return 
[
	'number'      => 52,
	'title'       => 'Permuted multiples',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-052_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-052.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-052_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=052',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-052.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 18887060,
	'time'        => 2917,
	'width'       => 45,
	'height'      => 6,
	'value'       => 142857,
];
