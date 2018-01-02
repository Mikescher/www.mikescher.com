<?php

class Blog
{
	public static function listAll()
	{
		$all =
		[
			[ 'id' => 5,  'date' => '2009-04-08', 'visible' => true,  'title' => 'Beginning the log',                      'fragment' => 'initial.md',         'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 6,  'date' => '2009-05-01', 'visible' => false, 'title' => 'Mess with the best ...',                 'fragment' => 'hack.md',            'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 4,  'date' => '2009-06-22', 'visible' => true,  'title' => 'New Layout!',                            'fragment' => 'newlayout.txt',      'type' => 'plain',    'cat' => 'log'  ],
			[ 'id' => 10, 'date' => '2009-06-28', 'visible' => true,  'title' => '"FUN" update',                           'fragment' => 'funupdate.md',       'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 11, 'date' => '2009-07-05', 'visible' => true,  'title' => 'New Download: LAN Control 2.0',          'fragment' => 'lancontrol.md',      'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 12, 'date' => '2009-09-07', 'visible' => false, 'title' => 'Airline BSOD',                           'fragment' => 'bsod.md',            'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 13, 'date' => '2009-11-22', 'visible' => true,  'title' => 'Spammers gonna spam',                    'fragment' => 'spammers.md',        'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 15, 'date' => '2012-04-14', 'visible' => true,  'title' => 'New Download: Infinity Tournament',      'fragment' => 'inftournament.md',   'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 16, 'date' => '2012-05-27', 'visible' => true,  'title' => 'New Download: Borderline Defense',       'fragment' => 'borderlinedef.md',   'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 17, 'date' => '2012-05-28', 'visible' => true,  'title' => 'Big clean up',                           'fragment' => 'cleanup.md',         'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 18, 'date' => '2013-01-03', 'visible' => true,  'title' => 'New Download: Crystal Grid',             'fragment' => 'crystalgrid.md',     'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 2,  'date' => '2014-05-14', 'visible' => true,  'title' => 'Let\'s do Befunge-93',                   'fragment' => 'befunge93.md',       'type' => 'markdown', 'cat' => 'blog' ],
			[ 'id' => 14, 'date' => '2014-06-30', 'visible' => true,  'title' => 'Language changes',                       'fragment' => 'language.txt',       'type' => 'plain',    'cat' => 'log'  ],
			[ 'id' => 1,  'date' => '2014-07-10', 'visible' => true,  'title' => 'Project Euler with Befunge',             'fragment' => '',                   'type' => 'euler',    'cat' => 'blog' ],
			[ 'id' => 3,  'date' => '2014-07-15', 'visible' => true,  'title' => '.Net format specifier Cheat Sheet',      'fragment' => 'net_format_spec.md', 'type' => 'markdown', 'cat' => 'blog' ],
			[ 'id' => 19, 'date' => '2014-08-04', 'visible' => true,  'title' => 'I am Number Four',                       'fragment' => 'v4.md',              'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 7,  'date' => '2014-09-28', 'visible' => true,  'title' => 'My BFJoust arena and battle-bot',        'fragment' => 'bfjoust.md',         'type' => 'markdown', 'cat' => 'blog' ],
			[ 'id' => 8,  'date' => '2014-11-05', 'visible' => true,  'title' => 'Rapla Enhancement Script',               'fragment' => 'rapla_css.md',       'type' => 'markdown', 'cat' => 'blog' ],
			[ 'id' => 20, 'date' => '2015-01-09', 'visible' => true,  'title' => 'More Befunge with Project Euler',        'fragment' => 'more_euler.md',      'type' => 'markdown', 'cat' => 'log'  ],
			[ 'id' => 9,  'date' => '2016-10-22', 'visible' => true,  'title' => 'A complete sudoku solver in Befunge-93', 'fragment' => 'sudoku_befunge.md',  'type' => 'markdown', 'cat' => 'blog' ],
			[ 'id' => 21, 'date' => '2018-01-02', 'visible' => true,  'title' => 'A simple javascript befunge-93 runner',  'fragment' => 'js_befrunner.md',    'type' => 'markdown', 'cat' => 'blog' ],
		];

		return array_map('self::completeSingle', $all);
	}

	private static function completeSingle($d)
	{
		if ($d['cat']==='blog')
			$d['url'] = "/blog/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);
		else if ($d['cat']==='log')
			$d['url'] = "/log/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);

		$d['canonical'] = "https://www.mikescher.com" . $d['url'];

		return $d;
	}

	public static function listAllOrderedDescending()
	{
		$data = self::listAll();
		usort($data, function($a, $b) { return strcasecmp($b['date'], $a['date']); });
		return $data;
	}

	public static function getBlogpost($id)
	{
		foreach (self::listAll() as $post) {
			if ($post['id'] == $id) return $post;
		}
		return null;
	}

	public static function getPostFragment($post)
	{
		return file_get_contents( __DIR__ . '/../statics/blog/' . $post['fragment']);
	}
}


