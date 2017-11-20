<?php

return 
[
	'number'      => 13,
	'title'       => 'Large sum',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-013_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-013.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-013_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=013',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-013.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 244792,
	'time'        => 78,
	'width'       => 59,
	'height'      => 113,
	'value'       => 5537376230,
];
