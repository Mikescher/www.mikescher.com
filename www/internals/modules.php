<?php

use internals\modules\ProjectLawful;

require_once 'website.php';

class Modules
{
	/** @var Database|null */            private $database = null;
	/** @var AdventOfCode|null */        private $adventOfCode = null;
	/** @var Blog|null */                private $blog = null;
	/** @var Books|null */               private $books = null;
	/** @var Euler|null */               private $euler = null;
	/** @var Programs|null */            private $programs = null;
	/** @var AlephNoteStatistics|null */ private $anstats = null;
	/** @var UpdatesLog|null */          private $updateslog = null;
	/** @var WebApps|null */             private $webapps = null;
	/** @var MikescherGitGraph|null */   private $extendedgitgraph = null;
	/** @var Highscores|null */          private $highscores = null;
    /** @var SelfTest|null */            private $selftest = null;
    /** @var ProjectLawful|null */       private $projectlawful = null;

	/** @var Website */
	private $site;

	public function __construct(Website $site)
	{
		$this->site = $site;
	}

	public function Database()
	{
		if ($this->database === null) { require_once 'modules/database.php'; $this->database = new Database($this->site); }
		return $this->database;
	}

	public function AdventOfCode(): AdventOfCode
	{
		if ($this->adventOfCode === null) { require_once 'modules/adventofcode.php'; $this->adventOfCode = new AdventOfCode(); }
		return $this->adventOfCode;
	}

	public function Blog(): Blog
	{
		if ($this->blog === null) { require_once 'modules/blog.php'; $this->blog = new Blog(); }
		return $this->blog;
	}

	public function Books(): Books
	{
		if ($this->books === null) { require_once 'modules/books.php'; $this->books = new Books($this->site); }
		return $this->books;
	}

	public function Euler(): Euler
	{
		if ($this->euler === null) { require_once 'modules/euler.php'; $this->euler = new Euler(); }
		return $this->euler;
	}

	public function Programs(): Programs
	{
		if ($this->programs === null) { require_once 'modules/programs.php'; $this->programs = new Programs(); }
		return $this->programs;
	}

	public function AlephNoteStatistics(): AlephNoteStatistics
	{
		if ($this->anstats === null) { require_once 'modules/alephnoteStatistics.php'; $this->anstats = new AlephNoteStatistics($this->site); }
		return $this->anstats;
	}

	public function UpdatesLog(): UpdatesLog
	{
		if ($this->updateslog === null) { require_once 'modules/updateslog.php'; $this->updateslog = new UpdatesLog($this->site); }
		return $this->updateslog;
	}

	public function WebApps(): WebApps
	{
		if ($this->webapps === null) { require_once 'modules/webapps.php'; $this->webapps = new WebApps(); }
		return $this->webapps;
	}

	public function ExtendedGitGraph(): MikescherGitGraph
	{
		if ($this->extendedgitgraph === null) { require_once 'modules/mikeschergitgraph.php'; $this->extendedgitgraph = new MikescherGitGraph($this->site->config['extendedgitgraph']); }
		return $this->extendedgitgraph;
	}

	public function Highscores(): Highscores
	{
		if ($this->highscores === null) { require_once 'modules/highscores.php'; $this->highscores = new Highscores($this->site); }
		return $this->highscores;
	}

    public function SelfTest(): SelfTest
    {
        if ($this->selftest === null) { require_once 'modules/selftest.php'; $this->selftest = new SelfTest(); }
        return $this->selftest;
    }

    public function ProjectLawful(): ProjectLawful
    {
        if ($this->projectlawful === null) { require_once 'modules/projectlawful.php'; $this->projectlawful = new ProjectLawful($this->site); }
        return $this->projectlawful;
    }
}