<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Database
{
	/* @var PDO $PDO */
	public static $PDO = NULL;

	public static function connect()
	{
		global $CONFIG;

		if (self::$PDO !== NULL) return;

		$dsn = "mysql:host=" . $CONFIG['host'] . ";dbname=" . $CONFIG['database'] . ";charset=utf8";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		self::$PDO = new PDO($dsn, $CONFIG['user'], $CONFIG['password'], $opt);
	}

	public static function sql_query_num($query)
	{
		$r = self::$PDO->query($query)->fetch(PDO::FETCH_NUM)[0];

		return $r;
	}

	public static function sql_query_num_prep($query, $params)
	{
		$stmt = self::$PDO->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		$r = $stmt->fetch(PDO::FETCH_NUM)[0];

		return $r;
	}

	public static function sql_query_assoc($query)
	{
		$r = self::$PDO->query($query)->fetchAll(PDO::FETCH_ASSOC);

		return $r;
	}

	public static function sql_query_assoc_prep($query, $params)
	{
		$stmt = self::$PDO->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $r;
	}

	public static function sql_query_single($query)
	{
		$r = self::$PDO->query($query)->fetch(PDO::FETCH_ASSOC);

		return $r;
	}

	public static function sql_query_single_prep($query, $params)
	{
		$stmt = self::$PDO->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		$r = $stmt->fetch(PDO::FETCH_ASSOC);

		return $r;
	}

	public static function sql_exec_prep($query, $params)
	{
		$stmt = self::$PDO->prepare($query);

		foreach ($params as $p)
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();

		return $stmt->rowCount();
	}
}