<?php

return 
[
	'number'      => 35,
	'title'       => 'Circular primes',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-035_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-035.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-035_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=035',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-035.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 176748467,
	'time'        => 27565,
	'width'       => 2000,
	'height'      => 516,
	'value'       => 55,
];
