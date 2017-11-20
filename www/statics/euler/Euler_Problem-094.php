<?php

return 
[
	'number'      => 94,
	'title'       => 'Almost equilateral triangles',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-094_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-094.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-094_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=094',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-094.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 2009,
	'time'        => 0,
	'width'       => 40,
	'height'      => 5,
	'value'       => 518408346,
];
