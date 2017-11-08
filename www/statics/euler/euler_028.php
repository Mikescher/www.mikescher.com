<?php

return 
[
	'number'      => 28,
	'title'       => 'Number spiral diagonals',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_028_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_028_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_028_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=028',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-028.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 28514,
	'time'        => 15,
	'width'       => 54,
	'height'      => 2,
	'value'       => 669171001,
];
