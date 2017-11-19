<?php

return 
[
	'number'      => 101,
	'title'       => 'Optimum polynomial',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_101_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_101_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_101_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=101',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-101.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1825656,
	'time'        => 250,
	'width'       => 83,
	'height'      => 37,
	'value'       => 37076114526,
];
