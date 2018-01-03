<?php

return 
[
	'name'              => 'Blitzer',
	'category'          => 'Hoax',
	'stars'             => 0,
	'ui_language'       => 'English',
	'prog_language'     => 'Delphi',
	'short_description' => 'Hoax you teachers/friends with flashing lights on your monitor.',
	'add_date'          => '2008-05-05',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Blitzer_description.md'); },
	'thumbnail_name'    => 'Blitzer.png',
];
