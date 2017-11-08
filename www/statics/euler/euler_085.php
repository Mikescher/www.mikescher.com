<?php

return 
[
	'number'      => 85,
	'title'       => 'Counting rectangles',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_085_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_085_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_085_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=085',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-085.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 880151,
	'time'        => 109,
	'width'       => 35,
	'height'      => 8,
	'value'       => 2772,
];
