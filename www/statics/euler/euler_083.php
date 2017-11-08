<?php

return 
[
	'number'      => 83,
	'title'       => 'Path sum: four ways',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_083_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_083_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_083_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=083',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-083.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 11718762,
	'time'        => 1748,
	'width'       => 500,
	'height'      => 180,
	'value'       => 425185,
];
