<?php

class Blog
{
	/** @var array */
	private $staticData;

	public function __construct()
	{
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/blog/__all.php');

		$this->staticData = array_map(function($a){return self::readSingle($a);}, $all);
	}

	private static function readSingle($d)
	{
		if ($d['cat']==='blog')
			$d['url'] = "/blog/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);
		else if ($d['cat']==='log')
			$d['url'] = "/log/" . $d['id'] . "/" . destructiveUrlEncode($d['title']);

		$d['canonical'] = "https://www.mikescher.com" . $d['url'];

		$d['file_fragment'] = __DIR__ . '/../../statics/blog/' . $d['fragment'];

		if (!array_key_exists('extras', $d)) $d['extras'] = [];

		return $d;
	}

	public function listAll()
	{
		return $this->staticData;
	}

	public function listAllNewestFirst()
	{
		$data = $this->staticData;
		usort($data, function($a, $b) { return strcasecmp($b['date'], $a['date']); });
		return $data;
	}

	public function getBlogpost($id)
	{
		foreach ($this->staticData as $post) {
			if ($post['id'] == $id) return $post;
		}
		return null;
	}

	/**
	 * @param string $id
	 * @param string $subview
	 * @param string $error
	 * @return array|null
	 */
	public function getFullBlogpost($id, $subview, &$error)
	{
		$post = $this->getBlogpost($id);
		if ($post === null) { $error="Blogpost not found"; return null; }

		$post['issubview'] = false;

		$isSubEuler  = ($post['type'] === 'euler' && $subview !== '');
		$eulerproblem = null;
		if ($isSubEuler)
		{
			$eulerproblem = Website::inst()->modules->Euler()->getEulerProblemFromStrIdent($subview);
			if ($eulerproblem === null) { $error="Project Euler entry not found"; return null; }
			$post['submodel'] = $eulerproblem;
			$post['issubview'] = true;
		}

		$isSubAdventOfCode = ($post['type'] === 'aoc' && $subview !== '');
		$adventofcodeday = null;
		if ($isSubAdventOfCode)
		{
			$adventofcodeday = Website::inst()->modules->AdventOfCode()->getDayFromStrIdent($post['extras']['aoc:year'], $subview);
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

	public function getPostFragment($post)
	{
		return file_get_contents($post['file_fragment']);
	}

	public function checkConsistency()
	{
		$keys = [];

		$this->load();

		foreach ($this->staticData as $post)
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


