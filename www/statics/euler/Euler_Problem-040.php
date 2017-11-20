<?php

return 
[
	'number'      => 40,
	'title'       => 'Champernowne\'s constant',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-040_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-040.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-040_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=040',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-040.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1486,
	'time'        => 16,
	'width'       => 69,
	'height'      => 7,
	'value'       => 210,
];
