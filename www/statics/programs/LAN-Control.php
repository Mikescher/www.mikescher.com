<?php

return 
[
	'name'              => 'LAN-Control',
	'category'          => 'Network administration',
	'stars'             => 1,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Controll essential features of an other computer over the LAN',
	'add_date'          => '2011-07-05',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/LAN-Control_description.md'); },
	'thumbnail_name'    => 'LAN-Control.png',
];
