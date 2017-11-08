<?php

return 
[
	'number'      => 96,
	'title'       => 'Su Doku',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_096_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_096_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_096_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=096',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-096.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 583893708,
	'time'        => 90918,
	'width'       => 218,
	'height'      => 50,
	'value'       => 24702,
];
