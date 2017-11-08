<?php

return 
[
	'number'      => 43,
	'title'       => 'Sub-string divisibility',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_043_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_043_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_043_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=043',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-043.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 821317,
	'time'        => 140,
	'width'       => 68,
	'height'      => 23,
	'value'       => 16695334890,
];
