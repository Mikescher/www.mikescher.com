<?php

return 
[
	'number'      => 17,
	'title'       => 'Number letter counts',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_017_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_017_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_017_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=017',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-017.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 179076,
	'time'        => 47,
	'width'       => 48,
	'height'      => 15,
	'value'       => 21124,
];
