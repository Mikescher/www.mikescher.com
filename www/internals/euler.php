<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Euler
{
	public static function readSingle($f)
	{
		$a = require $f;

		$n3p = str_pad($a['number'], 3, '0', STR_PAD_LEFT);
		$a['number3'] = $n3p;

		$a['rating'] = self::rateTime($a);

		$a['url']       = '/blog/1/Project_Euler_with_Befunge/problem-' . $n3p;
		$a['canonical'] = "https://www.mikescher.com" . $a['url'];

		$a['is93'] = ($a['width'] <= 80 AND $a['height'] <= 25);

		$a['url_euler']  = 'https://projecteuler.net/problem=' . $n3p;
		$a['url_raw']    = 'https://raw.githubusercontent.com/Mikescher/Project-Euler_Befunge/master/processed/Euler_Problem-' . $n3p . '.b93';
		$a['url_github'] =  'https://github.com/Mikescher/Project-Euler_Befunge';

		$a['file_description'] = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'_description.md');
		$a['file_code']        = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'.b93');
		$a['file_explanation'] = (__DIR__ . '/../statics/euler/Euler_Problem-'.$n3p.'_explanation.md');

		return $a;
	}

	public static function listAll()
	{
		$expr = __DIR__ . '/../statics/euler/Euler_Problem-*.php';
		$files = glob($expr);
		
		return array_map('self::readSingle', $files);
	}

	public static function getEulerProblem($num)
	{
		foreach (self::listAll() as $ep) {
			if ($ep['number'] == $num) return $ep;
		}
		return null;
	}

	public static function rateTime($problem)
	{
		if ($problem['time'] < 100) // < 100ms
			return 0;

		if ($problem['time'] < 15 * 1000) // < 5s
			return 1;

		if ($problem['time'] < 60 * 1000) // < 1min
			return 2;

		if ($problem['time'] < 5 * 60 * 1000) // < 5min
			return 3;

		return 4;
	}
}

