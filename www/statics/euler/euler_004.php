<?php

return 
[
	'number'      => 4,
	'title'       => 'Largest palindrome product',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_004_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_004_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_004_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=004',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-004.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 230611114,
	'time'        => 77813,
	'width'       => 71,
	'height'      => 6,
	'value'       => 906609,
];
