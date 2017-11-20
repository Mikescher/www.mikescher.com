<?php

return 
[
	'number'      => 48,
	'title'       => 'Self powers',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-048_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-048.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-048_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=048',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-048.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 11530541,
	'time'        => 3728,
	'width'       => 37,
	'height'      => 3,
	'value'       => 9110846700,
];
