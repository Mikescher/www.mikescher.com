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

	function seedWithDailySeed($date)
	{
		$this->seed(($date->format('Y') % 100) * 10459);
		$max = $date->format('z');
		for ($i = 0; $i < $max; $i++) {
			$this->get();
		}
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
} 