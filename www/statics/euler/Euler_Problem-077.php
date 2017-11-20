<?php

return 
[
	'number'      => 77,
	'title'       => 'Prime summations',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-077_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-077.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-077_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=077',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-077.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 312139,
	'time'        => 47,
	'width'       => 101,
	'height'      => 39,
	'value'       => 71,
];
