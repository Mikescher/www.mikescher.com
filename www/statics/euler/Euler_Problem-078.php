<?php

return 
[
	'number'      => 78,
	'title'       => 'Coin partitions',
	'description' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-078_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-078.b93');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/Euler_Problem-078_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=078',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-078.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 1191633332,
	'time'        => 170946,
	'width'       => 251,
	'height'      => 256,
	'value'       => 55374,
];
