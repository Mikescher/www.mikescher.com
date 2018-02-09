<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once __DIR__ . '/base.php';

class Books
{
	public static function readSingle($a)
	{
		$a['imgfront_url']      =              '/data/images/book_img/' . $a['id'] . '_front.png';
		$a['imgfront_path']     = __DIR__ . '/../data/images/book_img/' . $a['id'] . '_front.png';

		$a['imgfull_url']       =              '/data/images/book_img/' . $a['id'] . '_full.png';
		$a['imgfull_path']      = __DIR__ . '/../data/images/book_img/' . $a['id'] . '_full.png';

		$a['preview_url']       =              '/data/dynamic/bookprev_' . $a['id'] . '.png';
		$a['preview_path']      = __DIR__ . '/../data/dynamic/bookprev_' . $a['id'] . '.png';

		$a['url']               = '/books/view/' . $a['id'] . '/' . destructiveUrlEncode($a['title']);

		$a['extraimages_urls']  = [];
		$a['extraimages_paths'] = [];

		for ($i=1; $i <= $a['imagecount']; $i++)
		{
			$a['extraimages_urls']  []=              '/data/images/book_img/' . $a['id'] . '_img' . $i . '.jpg';
			$a['extraimages_paths'] []= __DIR__ . '/../data/images/book_img/' . $a['id'] . '_img' . $i . '.jpg';
		}

		return $a;
	}

	public static function listAll()
	{
		$all = require (__DIR__ . '/../statics/books/__all.php');

		return array_map('self::readSingle', $all);
	}

	public static function listAllNewestFirst()
	{
		$data = self::listAll();
		usort($data, function($a, $b) { return strcasecmp($b['date'], $a['date']); });
		return $data;
	}

	public static function checkConsistency()
	{
		$warn = null;

		$ids = [];

		foreach (self::listAll() as $prog)
		{
			if (in_array($prog['id'], $ids)) return ['result'=>'err', 'message' => 'Duplicate id ' . $prog['id']];
			$ids []= $prog['id'];

			if (!file_exists($prog['imgfront_path'])) return ['result'=>'err', 'message' => 'Image not found ' . $prog['title_short']];
			if (!file_exists($prog['imgfull_path']))  return ['result'=>'err', 'message' => 'Image not found ' . $prog['title_short']];

			foreach ($prog['extraimages_paths'] as $eipath)
			{
				if (!file_exists($eipath)) return ['result'=>'err', 'message' => 'Extra-Image not found ' . $prog['title_short']];
			}
		}

		if ($warn != null) return $warn;
		return ['result'=>'ok', 'message' => ''];
	}

	public static function checkThumbnails()
	{
		foreach (self::listAll() as $book)
		{
			if (!file_exists($book['preview_path'])) return ['result'=>'err', 'message' => 'Preview not found ' . $book['title_short']];
		}

		return ['result'=>'ok', 'message' => ''];
	}

	public static function createPreview($prog)
	{
		global $CONFIG;

		$src = $prog['imgfront_path'];
		$dst = $prog['preview_path'];

		if ($CONFIG['use_magick'])
			magick_resize_image($src, 200, 0, $dst);
		else
			smart_resize_image($src, 200, 0, true, $dst);

	}

	public static function getBook($id)
	{
		foreach (self::listAll() as $book) {
			if ($book['id'] == $id) return $book;
		}
		return null;
	}
}