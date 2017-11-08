<?php

return 
[
	'number'      => 55,
	'title'       => 'Lychrel numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_055_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_055_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_055_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=055',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-055.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 10470329,
	'time'        => 2215,
	'width'       => 56,
	'height'      => 5,
	'value'       => 249,
];
