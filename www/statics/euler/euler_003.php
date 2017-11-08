<?php

return 
[
	'number'      => 3,
	'title'       => 'Largest prime factor',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_003_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_003_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_003_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=003',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-003.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 31579516,
	'time'        => 9547,
	'width'       => 55,
	'height'      => 4,
	'value'       => 6857,
];
