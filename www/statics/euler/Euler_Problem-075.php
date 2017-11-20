<?php

return 
[
	'number'      => 75,
	'title'       => 'Singular integer right triangles',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-075_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-075.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-075_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=075',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-075.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 293080647,
	'time'        => 39951,
	'width'       => 1000,
	'height'      => 1515,
	'value'       => 161667,
];
