<?php

return 
[
	'number'      => 6,
	'title'       => 'Sum square difference',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-006_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-006.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-006_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=006',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-006.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 18897151,
	'time'        => 7347,
	'width'       => 72,
	'height'      => 16,
	'value'       => 25164150,
];
