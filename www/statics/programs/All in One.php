<?php

return 
[
	'name'              => 'All in One',
	'category'          => 'Tool',
	'stars'             => 1,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'A little \"swiss army knife\" programm with over 100 different functionalities',
	'add_date'          => '2008-11-26',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/All in One_description.md'); },
	'thumbnail_url'     => 'All in One.png',
];
