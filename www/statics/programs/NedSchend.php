<?php

return 
[
	'name'              => 'NedSchend',
	'category'          => 'Hoax',
	'stars'             => 1,
	'ui_language'       => 'German',
	'prog_language'     => 'Delphi',
	'short_description' => 'Send anonymous messages over the Windows Messenger service to other pc\"s in your " +
    "LAN',
	'add_date'          => '2009-02-11',
	'urls'              =>
	[
		'download'    => 'direkt',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/NedSchend_description.md'); },
	'thumbnail_url'     => '/images/program_thumbnails/NedSchend.png',
];
