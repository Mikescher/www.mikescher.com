<?php

return 
[
	'name'              => 'absCanvas',
	'category'          => 'Engine',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'Java',
	'short_description' => 'A powerful 2D Tiled-Game-Engine for java. Completely in canvas and with network s" +
    "upport.',
	'add_date'          => '2012-05-28',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/absCanvas_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/absCanvas.png',
];
