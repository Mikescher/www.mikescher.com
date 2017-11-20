<?php

return 
[
	'number'      => 42,
	'title'       => 'Coded triangle numbers',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-042_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-042.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-042_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=042',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-042.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 526637,
	'time'        => 406,
	'width'       => 112,
	'height'      => 1788,
	'value'       => 162,
];
