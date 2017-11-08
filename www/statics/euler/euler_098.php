<?php

return 
[
	'number'      => 98,
	'title'       => 'Anagramic squares',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_098_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_098_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_098_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=098',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-098.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 145592567,
	'time'        => 22714,
	'width'       => 258,
	'height'      => 199,
	'value'       => 18769,
];
