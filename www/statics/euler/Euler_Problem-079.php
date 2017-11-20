<?php

return 
[
	'number'      => 79,
	'title'       => 'Passcode derivation',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-079_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-079.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-079_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=079',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-079.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 12040,
	'time'        => 0,
	'width'       => 56,
	'height'      => 21,
	'value'       => 73162890,
];
