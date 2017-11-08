<?php

return 
[
	'number'      => 84,
	'title'       => 'Monopoly odds',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_084_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_084_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_084_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=084',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-084.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 146519794,
	'time'        => 19203,
	'width'       => 77,
	'height'      => 20,
	'value'       => 101524,
];
