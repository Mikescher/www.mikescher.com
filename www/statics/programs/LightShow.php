<?php

return 
[
	'name'              => 'LightShow',
	'category'          => 'Hoax',
	'stars'             => 0,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Turn you keyboard-LED\"s into a little lightshow',
	'add_date'          => '2008-10-12',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/LightShow_description.md'); },
	'thumbnail_url'     => 'LightShow.png',
];
