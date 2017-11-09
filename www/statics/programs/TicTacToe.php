<?php

return 
[
	'name'              => 'TicTacToe',
	'category'          => 'Game',
	'stars'             => 1,
	'ui_language'       => 'English',
	'prog_language'     => 'Delphi',
	'short_description' => 'The classical Tic-Tac-Toe, complete with perfect KI and Sourcecode.',
	'add_date'          => '2011-01-19',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/TicTacToe_description.md'); },
	'thumbnail_url'     => 'TicTacToe.png',
];
