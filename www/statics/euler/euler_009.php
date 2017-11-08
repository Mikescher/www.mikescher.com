<?php

return 
[
	'number'      => 9,
	'title'       => 'Special Pythagorean triplet',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_009_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_009_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_009_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=009',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-009.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1397212134,
	'time'        => 394277,
	'width'       => 79,
	'height'      => 7,
	'value'       => 31875000,
];
