<?php

return 
[
	'number'      => 86,
	'title'       => 'Cuboid route',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_086_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_086_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_086_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=086',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-086.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 599659030,
	'time'        => 91822,
	'width'       => 66,
	'height'      => 10,
	'value'       => 1818,
];
