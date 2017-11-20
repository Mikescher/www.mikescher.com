<?php

return 
[
	'number'      => 23,
	'title'       => 'Non-abundant sums',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-023_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-023.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-023_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=023',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-023.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 10667174483,
	'time'        => 1967688,
	'width'       => 400,
	'height'      => 88,
	'value'       => 4179871,
];
