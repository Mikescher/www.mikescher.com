<?php

return 
[
	'number'      => 66,
	'title'       => 'Diophantine equation',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_066_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_066_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_066_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=066',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-066.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 262481767,
	'time'        => 55831,
	'width'       => 80,
	'height'      => 25,
	'value'       => 661,
];
