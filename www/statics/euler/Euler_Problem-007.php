<?php

return 
[
	'number'      => 7,
	'title'       => '10001st prime',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-007_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-007.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-007_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=007',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-007.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 21915385,
	'time'        => 7628,
	'width'       => 1000,
	'height'      => 156,
	'value'       => 104743,
];
