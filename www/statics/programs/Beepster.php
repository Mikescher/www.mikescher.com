<?php

return 
[
	'name'              => 'Beepster',
	'category'          => 'Hoax',
	'stars'             => 0,
	'ui_language'       => 'English',
	'prog_language'     => 'Delphi',
	'short_description' => 'Annoy your teachers/freinds with a very high pitched sound, even without external" +
    " speakers.',
	'add_date'          => '2008-06-04',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Beepster_description.md'); },
	'thumbnail_url'     => 'Beepster.png',
];
