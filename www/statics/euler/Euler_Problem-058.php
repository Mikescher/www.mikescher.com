<?php

return 
[
	'number'      => 58,
	'title'       => 'Spiral primes',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-058_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-058.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-058_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=058',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-058.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 78283096,
	'time'        => 12199,
	'width'       => 50,
	'height'      => 17,
	'value'       => 26241,
];
