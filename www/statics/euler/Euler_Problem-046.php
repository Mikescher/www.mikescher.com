<?php

return 
[
	'number'      => 46,
	'title'       => 'Goldbach\'s other conjecture',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-046_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-046.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-046_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=046',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-046.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 77542913,
	'time'        => 13899,
	'width'       => 200,
	'height'      => 57,
	'value'       => 5777,
];
