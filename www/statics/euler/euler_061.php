<?php

return 
[
	'number'      => 61,
	'title'       => 'Cyclical figurate numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_061_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_061_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_061_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=061',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-061.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 50105245,
	'time'        => 14414,
	'width'       => 80,
	'height'      => 25,
	'value'       => 28684,
];
