<?php

return 
[
	'number'      => 71,
	'title'       => 'Ordered fractions',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_071_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_071_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_071_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=071',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-071.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 77428679,
	'time'        => 11981,
	'width'       => 73,
	'height'      => 8,
	'value'       => 428570,
];
