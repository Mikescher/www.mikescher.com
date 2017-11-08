<?php

return 
[
	'number'      => 32,
	'title'       => 'Pandigital products',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_032_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_032_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_032_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=032',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-032.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 42123428,
	'time'        => 7191,
	'width'       => 166,
	'height'      => 21,
	'value'       => 45228,
];
