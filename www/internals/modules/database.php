<?php

class Database
{
	/* @var PDO $pdo */
	private $pdo = NULL;

	public function __construct(Website $site)
	{
		$this->connect($site->config);
	}

	private function connect(array $config)
	{
		$dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['database'] . ";charset=utf8";
		$opt =
		[
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		$this->pdo = new PDO($dsn, $config['user'], $config['password'], $opt);
	}

	public function sql_query_num($query)
	{
		return $this->pdo->query($query)->fetch(PDO::FETCH_NUM)[0];
	}

	public function sql_query_num_prep($query, $params)
	{
		$stmt = $this->pdo->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_NUM)[0];
	}

	public function sql_query_assoc($query)
	{
		return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
	}

	public  function sql_query_assoc_prep($query, $params)
	{
		$stmt = $this->pdo->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function sql_query_single($query)
	{
		return $this->pdo->query($query)->fetch(PDO::FETCH_ASSOC);
	}

	public function sql_query_single_prep($query, $params)
	{
		$stmt = $this->pdo->prepare($query);
		
		foreach ($params as $p) 
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function sql_exec_prep($query, $params)
	{
		$stmt = $this->pdo->prepare($query);

		foreach ($params as $p)
		{
			if (strpos($query, $p[0]) !== FALSE) $stmt->bindValue($p[0], $p[1], $p[2]);
		}

		$stmt->execute();

		return $stmt->rowCount();
	}
}