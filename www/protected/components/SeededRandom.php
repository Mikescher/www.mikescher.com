<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 28.05.14
 * Time: 09:15
 */

class SeededRandom
{
	var $RSeed = 0;

	function seed($s = 0)
	{
		$this->RSeed = abs(intval($s)) % 9999999 + 1;
		$this->get();
	}

	function seedWithDailySeed()
	{
		$this->seed($this->getDailySeed());
	}

	function get($min = 0, $max = 9999999)
	{
		if ($this->RSeed == 0)
			$this->seed(mt_rand());

		$this->RSeed = ($this->RSeed * 125) % 2796203;

		return $this->RSeed % ($max - $min) + $min;
	}

	function getRandomElement(array $arr)
	{
		return $arr[$this->get(0, count($arr))];
	}

	function getDailySeed()
	{
		$now = getdate();

		return ($now['year'] % 100) * 366 + $now['yday'] /* * $now['seconds'] */;
	}
} 