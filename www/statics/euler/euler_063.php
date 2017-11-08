<?php

return 
[
	'number'      => 63,
	'title'       => 'Powerful digit counts',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_063_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_063_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_063_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=063',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-063.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 8880369,
	'time'        => 2762,
	'width'       => 80,
	'height'      => 10,
	'value'       => 49,
];
