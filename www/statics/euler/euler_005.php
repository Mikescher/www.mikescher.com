<?php

return 
[
	'number'      => 5,
	'title'       => 'Smallest multiple',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_005_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_005_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_005_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=005',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-005.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 50166,
	'time'        => 47,
	'width'       => 73,
	'height'      => 6,
	'value'       => 232792560,
];
