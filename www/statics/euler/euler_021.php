<?php

return 
[
	'number'      => 21,
	'title'       => 'Amicable numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_021_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_021_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_021_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=021',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-021.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 601124986,
	'time'        => 102399,
	'width'       => 400,
	'height'      => 33,
	'value'       => 31626,
];
