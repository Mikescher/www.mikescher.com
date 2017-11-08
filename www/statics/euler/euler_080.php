<?php

return 
[
	'number'      => 80,
	'title'       => 'Square root digital expansion',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_080_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_080_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_080_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=080',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-080.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 540417723,
	'time'        => 116439,
	'width'       => 69,
	'height'      => 18,
	'value'       => 40886,
];
