<?php

return 
[
	'number'      => 50,
	'title'       => 'Consecutive prime sum',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-050_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-050.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-050_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=050',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-050.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 180368553,
	'time'        => 30904,
	'width'       => 2000,
	'height'      => 512,
	'value'       => 997651,
];
