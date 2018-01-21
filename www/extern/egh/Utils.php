<?php

class Utils
{
	public static function sharpFormat($str, $args)
	{
		foreach ($args as $key => $val)
		{
			$str = str_replace('{'.$key.'}', $val, $str);
		}
		return $str;
	}

	public static function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}