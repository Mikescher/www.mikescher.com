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

		$d['file_fragment'] = __DIR__ . '/../statics/blog/' . $d['fragment'];

		return $d;
	}

	public static function listAllNewestFirst()
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
		return file_get_contents($post['file_fragment']);
	}

	public static function checkConsistency()
	{
		$keys = [];

		foreach (self::listAll() as $post)
		{
			if (in_array($post['id'], $keys)) return ['result'=>'err', 'message' => 'Duplicate key ' . $post['id']];
			$keys []= $post['id'];

			if ($post['cat'] !== 'log' && $post['cat'] !== 'blog') return ['result'=>'err', 'message' => 'Unknown cat ' . $post['cat']];

			if ($post['type'] === 'markdown') {

				if (!file_exists($post['file_fragment'])) return ['result'=>'err', 'message' => 'Fragment not found ' . $post['fragment']];

			} else if ($post['type'] === 'plain') {

				if (!file_exists($post['file_fragment'])) return ['result'=>'err', 'message' => 'Fragment not found ' . $post['fragment']];

			} else if ($post['type'] === 'euler') {

				// aok

			} else {

				return ['result'=>'err', 'message' => 'Unknown type ' . $post['type']];

			}
		}

		return ['result'=>'ok', 'message' => ''];
	}
}


