<?php

return 
[
	'number'      => 11,
	'title'       => 'Largest product in a grid',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-011_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-011.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-011_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=011',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-011.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 323945,
	'time'        => 78,
	'width'       => 151,
	'height'      => 31,
	'value'       => 70600674,
];
