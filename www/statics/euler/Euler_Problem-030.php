<?php

return 
[
	'number'      => 30,
	'title'       => 'Digit fifth powers',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-030_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-030.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-030_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=030',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-030.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 51019199,
	'time'        => 7332,
	'width'       => 59,
	'height'      => 8,
	'value'       => 443839,
];
