<?php

return 
[
	'number'      => 102,
	'title'       => 'Triangle containment',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-102_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-102.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-102_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=102',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-102.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 1995449,
	'time'        => 281,
	'width'       => 80,
	'height'      => 1009,
	'value'       => 228,
];
