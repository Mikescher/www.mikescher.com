<?php

return 
[
	'name'              => 'SharkSim',
	'category'          => 'Simulation',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'C++',
	'short_description' => 'A simple implementation of the Wa-Tor cellular automaton',
	'add_date'          => '2013-07-12',
	'urls'              =>
	[
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/SharkSim_description.md'); },
	'thumbnail_url'     => 'SharkSim.png',
];
