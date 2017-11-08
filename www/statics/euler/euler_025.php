<?php

return 
[
	'number'      => 25,
	'title'       => '1000-digit Fibonacci number',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_025_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_025_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_025_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=025',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-025.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 745055403,
	'time'        => 116938,
	'width'       => 123,
	'height'      => 28,
	'value'       => 4782,
];
