<?php

return 
[
	'number'      => 99,
	'title'       => 'Largest exponential',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-099_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-099.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-099_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=099',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-099.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 5072021,
	'time'        => 1107,
	'width'       => 63,
	'height'      => 1000,
	'value'       => 709,
];
