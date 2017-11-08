<?php

return 
[
	'number'      => 89,
	'title'       => 'Roman numerals',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_089_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_089_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_089_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=089',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-089.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 569231,
	'time'        => 78,
	'width'       => 73,
	'height'      => 1009,
	'value'       => 743,
];
