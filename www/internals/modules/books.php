<?php

class Books implements IWebsiteModule
{
	/** @var Website */
	private $site;

	/** @var array */
	private $staticData;

	public function __construct(Website $site)
	{
		$this->site = $site;
		$this->load();
	}

	private function load()
	{
		$all = require (__DIR__ . '/../../statics/books/__all.php');

		$this->staticData = array_map(function($a){return self::readSingle($a);}, $all);
	}

	private static function readSingle($a)
	{
		$a['imgfront_url']      =                 '/data/images/book_img/' . $a['id'] . '_front.png';
		$a['imgfront_path']     = __DIR__ . '/../../data/images/book_img/' . $a['id'] . '_front.png';

		$a['imgfull_url']       =                 '/data/images/book_img/' . $a['id'] . '_full.png';
		$a['imgfull_path']      = __DIR__ . '/../../data/images/book_img/' . $a['id'] . '_full.png';

		$a['preview_url']       =                 '/data/dynamic/bookprev_' . $a['id'] . '.png';
		$a['preview_path']      = __DIR__ . '/../../data/dynamic/bookprev_' . $a['id'] . '.png';

		$a['file_readme']       = (__DIR__ . '/../../statics/books/' . $a['id'] . '.md');

		$a['url']               = '/books/view/' . $a['id'] . '/' . destructiveUrlEncode($a['title']);

		$a['extraimages_urls']  = [];
		$a['extraimages_paths'] = [];

		for ($i=1; $i <= $a['imagecount']; $i++)
		{
			$a['extraimages_urls']  []=                 '/data/images/book_img/' . $a['id'] . '_img' . $i . '.jpg';
			$a['extraimages_paths'] []= __DIR__ . '/../../data/images/book_img/' . $a['id'] . '_img' . $i . '.jpg';
		}

		$a['book_count'] = is_array($a['pdf']) ? count($a['pdf']) : 1;

		return $a;
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

	public function checkConsistency()
	{
		$warn = null;

		$this->load();

		$ids = [];

		foreach ($this->staticData as $book)
		{
			if (in_array($book['id'], $ids)) return ['result'=>'err', 'message' => 'Duplicate id ' . $book['id']];
			$ids []= $book['id'];

			if (!file_exists($book['imgfront_path'])) return ['result'=>'err', 'message' => 'Image (Front) not found ' . $book['title_short']];
			if (!file_exists($book['imgfull_path']))  return ['result'=>'err', 'message' => 'Image (Full) not found ' . $book['title_short']];

			foreach ($book['extraimages_paths'] as $eipath)
			{
				if (!file_exists($eipath)) return ['result'=>'err', 'message' => 'Extra-Image not found ' . $book['title_short']];
			}

			if ($book['book_count'] < 0) return ['result'=>'err', 'message' => 'BookCount must be greater than zero ' . $book['title_short']];

			if ($book['book_count'] > 1 && !is_array($book['pdf'])) return ['result'=>'err', 'message' => 'Attribute [pdf] must be an array ' . $book['title_short']];
			if ($book['book_count'] > 1 && count($book['pdf']) !== $book['book_count']) return ['result'=>'err', 'message' => 'Attribute [pdf] must be the correct size ' . $book['title_short']];
			if ($book['book_count'] === 1 && !is_string($book['pdf'])) return ['result'=>'err', 'message' => 'Attribute [pdf] must be an string ' . $book['title_short']];

			if ($book['book_count'] > 1 && !is_array($book['pages'])) return ['result'=>'err', 'message' => 'Attribute [pages] must be an array ' . $book['title_short']];
			if ($book['book_count'] > 1 && count($book['pages']) !== $book['book_count']) return ['result'=>'err', 'message' => 'Attribute [pages] must be the correct size ' . $book['title_short']];
			if ($book['book_count'] === 1 && !is_string($book['pages'])) return ['result'=>'err', 'message' => 'Attribute [pages] must be an string ' . $book['title_short']];

			if (!file_exists($book['file_readme'])) return ['result'=>'err', 'message' => 'Readme not found ' . $book['title_short']];

			if (!file_exists($book['preview_path'])) $warn = ['result'=>'warn', 'message' => 'Preview not found ' . $book['title_short']];
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}

	public function createPreview($prog)
	{
		$src = $prog['imgfront_path'];
		$dst = $prog['preview_path'];

		if ($this->site->config['use_magick'])
			magick_resize_image($src, 200, 0, $dst);
		else
			smart_resize_image($src, 200, 0, true, $dst);

	}

	public function getBook($id)
	{
		foreach (self::listAll() as $book) {
			if ($book['id'] == $id) return $book;
		}
		return null;
	}

	public function getRepositoryHost($book)
	{
		$r = $book['repository'];
		if (startsWith($r, "http://")) $r = substr($r, strlen("http://"));
		if (startsWith($r, "https://")) $r = substr($r, strlen("https://"));
		if (startsWith($r, "www.")) $r = substr($r, strlen("www."));

		if (startsWith(strtolower($r), "gitlab"))    return "Gitlab";
		if (startsWith(strtolower($r), "github"))    return "Github";
		if (startsWith(strtolower($r), "bitbucket")) return "Bitbucket";

		return "Online";
	}

	public function getREADME($book)
	{
		return file_get_contents($book['file_readme']);
	}
}