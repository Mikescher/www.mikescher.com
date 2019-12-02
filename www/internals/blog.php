<?php

class Blog
{
	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/blog/__all.php');

		return array_map('self::readSingle', $all);
	}

	private static function readSingle($d)
	{
		if ($d['cat']==='blog')
			$d['url'] = "/blog/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);
		else if ($d['cat']==='log')
			$d['url'] = "/log/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);

		$d['canonical'] = "https://www.mikescher.com" . $d['url'];

		$d['file_fragment'] = __DIR__ . '/../statics/blog/' . $d['fragment'];

		if (!array_key_exists('extras', $d)) $d['extras'] = [];

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

	public static function getFullBlogpost($id, $subview, &$error)
	{
		$post = self::getBlogpost($id);
		if ($post === null) { $error="Blogpost not found"; return null; }

		$post['issubview'] = false;

		$isSubEuler  = ($post['type'] === 'euler' && $subview !== '');
		$eulerproblem = null;
		if ($isSubEuler)
		{
			require_once(__DIR__ . '/../internals/euler.php');
			$eulerproblem = Euler::getEulerProblemFromStrIdent($subview);
			if ($eulerproblem === null) { $error="Project Euler entry not found"; return null; }
			$post['submodel'] = $eulerproblem;
			$post['issubview'] = true;
		}

		$isSubAdventOfCode = ($post['type'] === 'aoc' && $subview !== '');
		$adventofcodeday = null;
		if ($isSubAdventOfCode)
		{
			require_once(__DIR__ . '/../internals/adventofcode.php');
			$adventofcodeday = AdventOfCode::getDayFromStrIdent($post['extras']['aoc:year'], $subview);
			if ($adventofcodeday === null) { $error="AdventOfCode entry not found"; return null; }
			$post['submodel'] = $adventofcodeday;
			$post['issubview'] = true;
		}

		if ($isSubEuler)        $post['title'] = $eulerproblem['title'];
		if ($isSubAdventOfCode) $post['title'] = $adventofcodeday['title'];

		if ($isSubEuler)        $post['canonical'] = $eulerproblem['canonical'];
		if ($isSubAdventOfCode) $post['canonical'] = $adventofcodeday['canonical'];

		return $post;

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

			} else if ($post['type'] === 'aoc') {

				if (!array_key_exists('aoc:year', $post['extras'])) return ['result'=>'err', 'message' => 'AdventOfCode metadata [aoc:year] missing: ' . $post['title']];

				// aok

			} else {

				return ['result'=>'err', 'message' => 'Unknown type ' . $post['type']];

			}
		}

		return ['result'=>'ok', 'message' => ''];
	}
}


