<?php

require_once "website.php";

class RuleEngine
{
	/**
	 * @param Website $app
	 * @param array $urlConfig
	 * @return URLRoute
	 */
	public static function findRoute(Website $app, array $urlConfig): URLRoute
	{
		if ($app->isProd())
			$requri = $_SERVER['REQUEST_URI'];
		else
			$requri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'localhost:80/';

		$parse = parse_url($requri);

		$path      = isset($parse['path']) ? $parse['path'] : '';
		$pathparts = preg_split('@/@', $path, NULL, PREG_SPLIT_NO_EMPTY);
		$partcount = count($pathparts);

		foreach ($urlConfig as $rule)
		{
			$route = self::testRule($app, $rule, $requri, $pathparts, $partcount);
			if ($route === null) continue;

			if ($route->needsAdminLogin && !$app->isLoggedIn()) return URLRoute::getLoginRoute($route, $requri);
		}

		return URLRoute::getNotFoundRoute($requri);
	}

	private static function testRule(Website $app, array $rule, string $requri, array $pathparts, int $partcount)
	{
		if ($partcount !== count($rule['url'])) return null;

		$urlparams = [];

		$match = true;
		for($i = 0; $i < $partcount; $i++)
		{
			$comp = $rule['url'][$i];
			if (startsWith($comp, '?{') && endsWith($comp, '}'))
			{
				$ident = substr($comp, 2, strlen($comp)-3);
				$urlparams[$ident] = $pathparts[$i];
			}
			else if ($comp === '*')
			{
				if (!isset($urlparams['*'])) $urlparams['*'] = [];
				$urlparams['*'] []= $pathparts[$i];
			}
			else
			{
				if (strtolower($comp) !== strtolower($pathparts[$i])) { $match = false; break; }
			}
		}
		if (!$match) return null;

		$route = new URLRoute($rule['target'], $requri);

		foreach($rule['parameter'] as $optname => $optvalue)
		{
			$value = $optvalue;

			if ($value === '%GET%')
			{
				if (!isset($_GET[$optname])) { $match = false; break; }
				$value = $_GET[$optname];
			}
			else if ($value === '%POST%')
			{
				if (!isset($_POST[$optname])) { $match = false; break; }
				$value = $_POST[$optname];
			}
			else if ($value === '%URL%')
			{
				if (!isset($urlparams[$optname])) { $match = false; break; }
				$value = urldecode($urlparams[$optname]);
			}

			$route->parameter[strtolower($optname)] = $value;
		}
		if (!$match) return null;

		$ctrlOpt = $rule['options'];

		if (in_array('disabled', $ctrlOpt)) return null;
		if (in_array('api', $ctrlOpt)) $route->isAPI = true;

		if (isset($ctrlOpt['method']) && $_SERVER["REQUEST_METHOD"] !== $ctrlOpt['method']) return null;

		$route->needsAdminLogin = isset($ctrlOpt['password']);

		if ($app->isProd() && isHTTPRequest() && !in_array('http', $ctrlOpt))
		{
			// enforce https
			$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			ob_end_clean();
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $redirect);
			exit();
		}

		return $route;
	}
}
