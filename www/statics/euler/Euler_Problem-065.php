<?php

return 
[
	'number'      => 65,
	'title'       => 'Convergents of e',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-065_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-065.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-065_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=065',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-065.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 477489,
	'time'        => 124,
	'width'       => 80,
	'height'      => 14,
	'value'       => 272,
];
