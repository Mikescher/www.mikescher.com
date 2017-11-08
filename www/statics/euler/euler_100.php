<?php

return 
[
	'number'      => 100,
	'title'       => 'Arranged probability',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_100_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_100_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_100_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=100',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-100.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1649,
	'time'        => 0,
	'width'       => 56,
	'height'      => 3,
	'value'       => 756872327473,
];
