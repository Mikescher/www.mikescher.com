<?php

return 
[
	'number'      => 53,
	'title'       => 'Combinatoric selections',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-053_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-053.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-053_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=053',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-053.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 372790,
	'time'        => 125,
	'width'       => 80,
	'height'      => 7,
	'value'       => 4075,
];
