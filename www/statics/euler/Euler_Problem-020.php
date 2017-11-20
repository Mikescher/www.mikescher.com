<?php

return 
[
	'number'      => 20,
	'title'       => 'Factorial digit sum',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-020_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-020.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-020_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=020',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-020.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1546679,
	'time'        => 265,
	'width'       => 101,
	'height'      => 6,
	'value'       => 648,
];
