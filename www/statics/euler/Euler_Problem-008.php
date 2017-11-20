<?php

return 
[
	'number'      => 8,
	'title'       => 'Largest product in a series',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-008_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-008.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-008_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=008',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-008.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 614295,
	'time'        => 234,
	'width'       => 116,
	'height'      => 29,
	'value'       => 23514624000,
];
