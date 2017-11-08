<?php

return 
[
	'number'      => 27,
	'title'       => 'Quadratic primes',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_027_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_027_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_027_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=027',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-027.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 37842282,
	'time'        => 6240,
	'width'       => 600,
	'height'      => 162,
	'value'       => -59231,
];
