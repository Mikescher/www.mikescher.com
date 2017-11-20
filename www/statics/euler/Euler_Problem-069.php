<?php

return 
[
	'number'      => 69,
	'title'       => 'Totient maximum',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-069_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-069.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-069_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=069',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-069.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 35542,
	'time'        => 16,
	'width'       => 80,
	'height'      => 10,
	'value'       => 510510,
];
