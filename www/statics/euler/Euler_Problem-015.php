<?php

return 
[
	'number'      => 15,
	'title'       => 'Lattice paths',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-015_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-015.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-015_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=015',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-015.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 61202,
	'time'        => 47,
	'width'       => 78,
	'height'      => 27,
	'value'       => 137846528820,
];
