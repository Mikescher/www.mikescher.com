<?php

return 
[
	'number'      => 22,
	'title'       => 'Names scores',
	'description' => function(){ return file_get_contents(__DIR__ . '/euler_022_description.md'); },
	'code'        => function(){ return file_get_contents(__DIR__ . '/euler_022_code.txt');        },
	'explanation' => function(){ return file_get_contents(__DIR__ . '/euler_022_explanation.md'); },
	'url_euler'   => 'http://projecteuler.net/problem=022',
	'url_raw'     => 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-022.b93',
	'url_github'  => 'https://github.com/Mikescher/Project-Euler_Befunge',
	'abbreviated' => true,
	'steps'       => 4703607994,
	'time'        => 961793,
	'width'       => 109,
	'height'      => 5164,
	'value'       => 871198282,
];
