<?php

require_once 'Utils.php';

interface ILogger
{
	public function proclog($text);
}

class FileLogger implements ILogger
{
	/** @var string $path */
	private $path;

	/**
	 * @var string $filename
	 * @var int $count
	 */
	public function __construct($filename, $count)
	{
		for ($i=$count-1;$i>0;$i--)
		{
			$f2 = Utils::sharpFormat($filename, [ 'num' => '_'.( $i   ) ]);
			$f1 = Utils::sharpFormat($filename, [ 'num' => '_'.( $i-1 ) ]);
			if ($i-1 === 0) $f1 = Utils::sharpFormat($filename, [ 'num' => '' ]);

			if (file_exists($f2)) @unlink($f2);
			if (file_exists($f1)) @rename($f1, $f2);
		}


		$f0 = Utils::sharpFormat($filename, ['num'=>''  ]);
		if (file_exists($f0)) @unlink($f0);
		$this->path = $f0;
	}

	public function proclog($text)
	{
		if ($text !== '') $text = '[' . date('H:i:s') . '] ' . $text;

		file_put_contents($this->path, $text . PHP_EOL , FILE_APPEND | LOCK_EX);
	}
}

class SingleFileLogger implements ILogger
{
	/** @var string $path */
	private $path;

	/**
	 * @var string $filename
	 */
	public function __construct($filename)
	{
		$this->path = $filename;
		file_put_contents($this->path, '', FILE_TEXT);
	}

	public function proclog($text)
	{
		file_put_contents($this->path, $text . PHP_EOL , FILE_APPEND | LOCK_EX);
	}
}

class SessionLogger implements ILogger
{
	/** @var string $sessionvar */
	private $sessionvar;

	/** @var string $sessionvar */
	public function __construct($sessionvar)
	{
		$this->sessionvar = $sessionvar;

		if (session_status() !== PHP_SESSION_DISABLED)
		{
			if (session_status() !== PHP_SESSION_ACTIVE) session_start();
			$_SESSION[$sessionvar] = '';
			session_commit();
		}
	}

	public function proclog($text)
	{
		if (session_status() === PHP_SESSION_DISABLED) return;

			if (session_status() !== PHP_SESSION_ACTIVE) session_start();
		if (session_status() !== PHP_SESSION_ACTIVE) session_start();
		$_SESSION[$this->sessionvar] .= $text . "\r\n";
		session_commit();
	}
}

class OutputLogger implements ILogger
{
	public function proclog($text)
	{
		if ($text !== '') $text = '[' . date('H:i:s') . '] ' . $text;

		print $text;
		print "\r\n";
	}

}