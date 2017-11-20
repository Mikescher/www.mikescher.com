<?php

return 
[
	'number'      => 97,
	'title'       => 'Large non-Mersenne prime',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-097_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-097.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-097_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=097',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-097.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => false,
	'steps'       => 164439636,
	'time'        => 21091,
	'width'       => 13,
	'height'      => 5,
	'value'       => 8739992577,
];
