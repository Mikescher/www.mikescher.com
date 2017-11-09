<?php

return 
[
	'name'              => 'Passpad',
	'category'          => 'Tool',
	'stars'             => 3,
	'ui_language'       => 'English',
	'prog_language'     => 'C#',
	'short_description' => 'A texteditor for encrypted textfiles (AES, Twofish, Blowfish, ...)',
	'add_date'          => '2015-11-26',
	'urls'              =>
	[
		'download'    => 'https://github.com/Mikescher/Passpad/releases',
		'github'      => 'https://github.com/Mikescher/Passpad',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/Passpad_description.md'); },
	'thumbnail_url'     => 'Passpad.png',
];
