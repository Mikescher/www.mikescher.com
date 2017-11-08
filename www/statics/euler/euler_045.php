<?php

return 
[
	'number'      => 45,
	'title'       => 'Triangular, pentagonal, and hexagonal',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_045_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_045_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_045_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=045',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-045.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 25312679,
	'time'        => 3494,
	'width'       => 48,
	'height'      => 6,
	'value'       => 1533776805,
];
