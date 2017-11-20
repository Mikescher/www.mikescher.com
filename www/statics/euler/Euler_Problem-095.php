<?php

return 
[
	'number'      => 95,
	'title'       => 'Amicable chains',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-095_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-095.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-095_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=095',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-095.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 1053466251,
	'time'        => 242737,
	'width'       => 2017,
	'height'      => 1035,
	'value'       => 14316,
];
