<?php

return 
[
	'number'      => 34,
	'title'       => 'Digit factorials',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_034_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_034_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_034_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=034',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-034.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 493980359,
	'time'        => 80933,
	'width'       => 45,
	'height'      => 7,
	'value'       => 40730,
];
