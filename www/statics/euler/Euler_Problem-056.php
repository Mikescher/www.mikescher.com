<?php

return 
[
	'number'      => 56,
	'title'       => 'Powerful digit sum',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-056_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-056.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-056_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=056',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-056.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 62461749,
	'time'        => 13915,
	'width'       => 75,
	'height'      => 11,
	'value'       => 972,
];
