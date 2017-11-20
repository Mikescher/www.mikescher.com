<?php

return 
[
	'number'      => 10,
	'title'       => 'Summation of primes',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-010_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-010.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-010_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=010',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-010.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 416776174,
	'time'        => 67127,
	'width'       => 2000,
	'height'      => 1007,
	'value'       => 142913828922,
];
