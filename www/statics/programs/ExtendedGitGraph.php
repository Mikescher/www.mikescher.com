<?php

return 
[
	'name'              => 'ExtendedGitGraph',
	'category'          => 'Library',
	'stars'             => 2,
	'ui_language'       => 'English',
	'prog_language'     => 'PHP',
	'short_description' => 'A simple php module to display a overview of you github commits',
	'add_date'          => '2014-06-08',
	'urls'              =>
	[
		'download'    => 'https://github.com/Mikescher/extendedGitGraph/',
	],
	'long_description'  => function(){ return file_get_contents(__DIR__ . '/ExtendedGitGraph_description.md'); },
	'thumbnail_url'     => 'ExtendedGitGraph.png',
];
