<?php

return 
[
	'number'      => 37,
	'title'       => 'Truncatable primes',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_037_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_037_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_037_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=037',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-037.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 128154558,
	'time'        => 20717,
	'width'       => 2000,
	'height'      => 514,
	'value'       => 748317,
];
