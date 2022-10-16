<?php

require_once (__DIR__ . '/../../extern/egg/ExtendedGitGraph2.php');
require_once (__DIR__ . '/../iwebsitemodule.php');

class MikescherGitGraph implements IWebsiteModule
{
	/** @var ExtendedGitGraph2 */
	private ExtendedGitGraph2 $extgitgraph;

	/** @noinspection PhpUnhandledExceptionInspection */
	public function __construct(array $egh_conf)
	{
		$this->extgitgraph = new ExtendedGitGraph2($egh_conf);
	}

	public function getPathRenderedData(): string
	{
		return __DIR__ . '/../../dynamic/egg/cache_fullrenderer.html';
	}

	public function update(): bool
	{
		return $this->extgitgraph->update();
	}

	public function updateCache(): ?string
	{
		return $this->extgitgraph->updateCache();
	}

	/**
	 * @return string|null
	 */
	public function get(): ?string
	{
		$d = $this->extgitgraph->loadFromCache();
		if ($d === null) return "";
		return $d;
	}

	public function checkConsistency(): array
	{
		$p = $this->getPathRenderedData();

		if (!file_exists($p)) return ['result'=>'err', 'message' => 'Rendered data not found'];

		if (filemtime($p) < time()-(24*60*60)) return ['result'=>'warn', 'message' => 'Rendered data is older than 1 day'];

		return ['result'=>'ok', 'message' => ''];
	}
}