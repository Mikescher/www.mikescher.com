<?php

class Utils
{
	/**
	 * @param string $str
	 * @param string[] $args
	 * @return string
	 */
	public static function sharpFormat(string $str, array $args)
	{
		foreach ($args as $key => $val)
		{
			$str = str_replace('{'.$key.'}', $val, $str);
		}
		return $str;
	}

	/**
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public static function startsWith(string $haystack, string $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public static function endsWith(string $haystack, string $needle)
	{
		$length = strlen($needle);
		return ($length === 0) || (substr($haystack, -$length) === $needle);
	}

	/**
	 * @param string $filter
	 * @param string[] $exclusions
	 * @param string $name
	 * @return bool
	 */
	public static function isRepoFilterMatch(string $filter, array $exclusions, string $name)
	{
		foreach ($exclusions as $ex)
		{
			if (strtolower($ex) === strtolower($name)) return false;
		}

		$f0 = explode('/', $filter);
		$f1 = explode('/', $name);

		if (count($f0) !== 2) return false;
		if (count($f1) !== 2) return false;

		if ($f0[0] !== $f1[0] && $f0[0] !== '*') return false;
		if ($f0[1] !== $f1[1] && $f0[1] !== '*') return false;

		return true;
	}

	/**
	 * @param ILogger $logger
	 * @param string $url
	 * @param string $authtoken
	 * @return array|mixed
	 */
	public static function getJSONWithTokenAuth($logger, $url, $authtoken)
	{
		return Utils::getJSON($logger, $url, 'Authorization: token ' . $authtoken);
	}

	/**
	 * @param ILogger $logger
	 * @param string $url
	 * @param string $usr
	 * @param string $pass
	 * @return array|mixed
	 */
	public static function getJSONWithTokenBasicAuth($logger, $url, $usr, $pass)
	{
		return Utils::getJSON($logger, $url, 'Authorization: Basic ' . base64_encode($usr.':'.$pass));
	}

	/**
	 * @param ILogger $logger
	 * @param string $url
	 * @param string $header
	 * @return array|mixed
	 */
	private static function getJSON($logger, $url, $header)
	{
		//$logger->proclog("[@] " . $url);

		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
			$options  =
				[
					'http'  =>
						[
							'user_agent' => $_SERVER['HTTP_USER_AGENT'],
							'header' => $header,
						],
					'https' =>
						[
							'user_agent' => $_SERVER['HTTP_USER_AGENT'],
							'header' => $header,
						],
				];
		} else {
			$options  =
				[
					'http' =>
						[
							'user_agent' => 'ExtendedGitGraph_for_mikescher.com',
							'header' => $header,
							'ignore_errors' => true,
						],
					'https' =>
						[
							'user_agent' => 'ExtendedGitGraph_for_mikescher.com',
							'header' => $header,
							'ignore_errors' => true,
						],
				];
		}

		$context  = stream_context_create($options);

		$response = @file_get_contents($url, false, $context);

		if ($response === false)
		{
			$logger->proclog("Error recieving json: '" . $url . "'");
			$logger->proclog(print_r(error_get_last(), true));
			return [];
		}

		return json_decode($response);
	}

	/**
	 * @return string
	 */
	public static function sqlnow()
	{
		return gmdate("Y-m-d H:i:s");
	}

	/**
	 * @param int $n0
	 * @param array $dbdata
	 * @return int
	 */
	public static function array_value_max(int $n0, array $dbdata): int
	{
		foreach ($dbdata as $_ => $val) $n0 = max($n0, $val);
		return $n0;
	}

	public static function urlCombine(string... $elements)
	{
		$r = $elements[0];
		$skip = true;
		foreach ($elements as $e)
		{
			if ($skip) { $skip=false; continue; }

			if (Utils::endsWith($r, '/')) $r = substr($r, 0, strlen($r)-1);
			if (Utils::startsWith($e, '/')) $e = substr($e, 1);

			$r = $r . '/' . $e;
		}
		return $r;
	}
}
