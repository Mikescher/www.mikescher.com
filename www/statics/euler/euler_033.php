<?php

return 
[
	'number'      => 33,
	'title'       => 'Digit canceling fractions',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_033_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_033_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_033_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=033',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-033.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 661502,
	'time'        => 109,
	'width'       => 67,
	'height'      => 18,
	'value'       => 100,
];
