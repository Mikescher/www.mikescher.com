<?php

return 
[
	'name'              => 'Deal or no Deal',
	'category'          => 'Game',
	'stars'             => 0,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'A digital version of the same-named german tv-show game.',
	'add_date'          => '2008-10-08',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Deal or no Deal_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Deal or no Deal.png',
];
