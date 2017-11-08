<?php

return 
[
	'name'              => 'Dynamic Link Fighters',
	'category'          => 'Game',
	'stars'             => 1,
	'ui_language'       => 'English|German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Program your own KI and let it fight against others in a brutal deathmatch.',
	'add_date'          => '2010-12-04',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Dynamic Link Fighters_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/Dynamic Link Fighters.png',
];
