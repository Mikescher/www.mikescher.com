<?php

return 
[
	'number'      => 88,
	'title'       => 'Product-sum numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-088_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-088.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-088_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=088',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-088.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 141097978,
	'time'        => 23852,
	'width'       => 1024,
	'height'      => 50,
	'value'       => 7587457,
];
