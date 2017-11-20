<?php

return 
[
	'number'      => 44,
	'title'       => 'Pentagon numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-044_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-044.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-044_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=044',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-044.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 1509045439,
	'time'        => 258993,
	'width'       => 60,
	'height'      => 11,
	'value'       => 5482660,
];
