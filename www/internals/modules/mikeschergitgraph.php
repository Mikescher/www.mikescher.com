<?php

require_once (__DIR__ . '/../../extern/egg/ExtendedGitGraph2.php');

class MikescherGitGraph
{
	/** @var ExtendedGitGraph2 */
	private $extgitgraph;

	/** @noinspection PhpUnhandledExceptionInspection */
	public function __construct(Website $site)
	{
		$this->extgitgraph = new ExtendedGitGraph2($site->config['extendedgitgraph']);
	}

	public function getPathRenderedData()
	{
		return __DIR__ . '/../../dynamic/egg/cache_fullrenderer.html';
	}

	public function update()
	{
		return $this->extgitgraph->update();
	}

	public function updateCache()
	{
		return $this->extgitgraph->updateCache();
	}

	/**
	 * @return string|null
	 */
	public function get()
	{
		$d = $this->extgitgraph->loadFromCache();
		if ($d === null) return "";
		return $d;
	}

	public function checkConsistency()
	{
		$p = $this->getPathRenderedData();

		if (!file_exists($p)) return ['result'=>'err', 'message' => 'Rendered data not found'];

		if (filemtime($p) < time()-(24*60*60)) return ['result'=>'warn', 'message' => 'Rendered data is older than 1 day'];

		return ['result'=>'ok', 'message' => ''];
	}
}