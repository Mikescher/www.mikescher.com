<?php

return 
[
	'number'      => 14,
	'title'       => 'Longest Collatz sequence',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-014_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-014.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-014_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=014',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-014.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 3877209672,
	'time'        => 717713,
	'width'       => 51,
	'height'      => 5,
	'value'       => 837799,
];
