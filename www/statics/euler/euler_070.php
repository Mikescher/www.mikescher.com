<?php

return 
[
	'number'      => 70,
	'title'       => 'Totient permutation',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_070_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_070_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_070_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=070',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-070.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 29380799,
	'time'        => 3713,
	'width'       => 150,
	'height'      => 47,
	'value'       => 8319823,
];
