<?php

return 
[
	'number'      => 54,
	'title'       => 'Poker hands',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_054_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_054_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_054_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=054',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-054.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 5949695,
	'time'        => 2543,
	'width'       => 118,
	'height'      => 1009,
	'value'       => 376,
];
