<?php

return 
[
	'number'      => 2,
	'title'       => 'Even Fibonacci numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_002_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_002_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_002_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=002',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-002.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1669,
	'time'        => 62,
	'width'       => 26,
	'height'      => 5,
	'value'       => 4613732,
];
