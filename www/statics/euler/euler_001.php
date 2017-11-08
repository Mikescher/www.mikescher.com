<?php

return 
[
	'number'      => 1,
	'title'       => 'Multiples of 3 and 5',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_001_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_001_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_001_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=001',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-001.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 47624,
	'time'        => 62,
	'width'       => 30,
	'height'      => 5,
	'value'       => 233168,
];
