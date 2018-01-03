<?php

class Blog
{
	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/blog/__all.php');

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


