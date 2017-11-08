<?php

return 
[
	'number'      => 41,
	'title'       => 'Pandigital prime',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_041_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_041_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_041_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=041',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-041.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 83726,
	'time'        => 31,
	'width'       => 40,
	'height'      => 17,
	'value'       => 7652413,
];
