<?php

return 
[
	'number'      => 31,
	'title'       => 'Coin sums',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-031_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-031.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-031_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=031',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-031.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 310409597,
	'time'        => 47970,
	'width'       => 60,
	'height'      => 11,
	'value'       => 73682,
];
