<?php

class ExtendedGitGraph {

	const FILE_RAW_DATA      = 'protected/data/git_graph_raw.dat';
	const FILE_FINISHED_DATA = 'protected/data/git_graph_data.dat';

	const API_AUTHORIZE = 'https://github.com/login/oauth/authorize?client_id=%s';
	const API_TOKEN     = 'https://github.com/login/oauth/access_token?client_id=%s&client_secret=%s&code=%s';

	const API_RATELIMIT        = 'https://api.github.com/rate_limit';
	const API_REPOSITORIESLIST = 'https://api.github.com/users/%s/repos?page=%d&per_page=100';
	const API_SINGLEREPOSITORY = 'https://api.github.com/repos/%s';

	const PROGRESS_SESSION_COOKIE = 'ajax_progress_egh_refresh';

	const COMMITCOUNT_COLOR_UPPERLIMIT = 16;

	private $username;
	private $token;
	private $tokenHeader;

	private $repositories;
	private $commits;

	private $sec_username = [];
	private $sec_repo = [];

	private $commitmap = array();
	private $startdate = null;
	private $enddate = null;

	public function __construct($usr_name) {
		$this->username = $usr_name;
	}

	public function authenticate($auth_key, $client_id, $client_secret) {
		$url = sprintf(self::API_TOKEN, $client_id, $client_secret, $auth_key);
		$result = file_get_contents($url);

		$result = str_replace('access_token=', '', $result);
		$result = str_replace('&scope=&token_type=bearer', '', $result);

		setToken($result);
	}

	public function setToken($token) {
		$this->token = $token;
		$this->tokenHeader = 'access_token=' . $token . '&token_type=bearer';
	}

	public function collect() {
		set_time_limit(300); // 5min

		$this->output_flushed_clear();
		$this->output_flushed("Start progress");

		$this->listRepositories();
		$this->listAllCommits();

		$this->save();

		$this->output_flushed("Remaining Requests: " . $this->getRemainingRequests());
		$this->output_flushed("Finished progress");
	}

	private function listRepositories()
	{
		$this->repositories = array();

		$this->listRepositoriesForUser($this->username);

		foreach ($this->sec_username as $un)
		{
			$this->listRepositoriesForUser($un);
		}

		foreach($this->sec_repo as $srep)
		{
			$this->listSingleRepo($srep);
		}
	}

	private function listRepositoriesForUser($usr) {
		$page = 1;
		$url = sprintf(self::API_REPOSITORIESLIST . '&' . $this->tokenHeader, $usr, $page);

		$result = $this->getJSON($url);

		while (! empty($result)) {
			foreach ($result as $result_repo) {
				$this->repositories[] = $this->parseRepoJSON($result_repo);

				$this->output_flushed("Found Repo: " . $result_repo->{'full_name'});
			}

			//##########

			$url = sprintf(self::API_REPOSITORIESLIST . '&' . $this->tokenHeader, $usr, ++$page);

			$result = $this->getJSON($url);
		}
	}

	private function listSingleRepo($repo)
	{
		$url = sprintf(self::API_SINGLEREPOSITORY . '?' . $this->tokenHeader, $repo);

		$result_repo = $this->getJSON($url);

		if (! empty($result_repo))
		{
			$this->repositories[] = $this->parseRepoJSON($result_repo);

			$this->output_flushed("Found Repo: " . $result_repo->{'full_name'});
		}
	}

	private function getJSON($url) {
		$options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
		$context  = stream_context_create($options);

		$response = @file_get_contents($url, false, $context);

		if ($response === false)
		{
			$this->output_flushed("Error recieving json: '" . $url . "'");
			return array();
		}

		return json_decode($response);
	}

	private function getRemainingRequests() {
		$json = $this->getJSON(self::API_RATELIMIT . '?' . $this->tokenHeader);

		return $json->{'resources'}->{'core'}->{'remaining'};
	}

	private function listAllCommits() {
		$this->commits = array();

		foreach($this->repositories as $repo) {
			$this->listCommits($repo);
		}
	}

	private function listCommits($repo) {
		$page = 1;
		$url = $repo['commits_url'] . '?per_page=100&page=' . $page . '&author=' .$this->username . '&' .$this->tokenHeader;

		$result = $this->getJSON($url);

		$commit_list = array();

		while (! empty($result)) {
			foreach ($result as $result_commit) {
				$commit_list[] = $this->parseCommitJSON($repo, $result_commit);
			}

			$this->output_flushed("Found " . count($result) . " Commits from  " . $repo['full_name']);

			//##########

			$url = $repo['commits_url'] . '?per_page=100&page=' . ++$page . '&author=' .$this->username . '&' .$this->tokenHeader;

			$result = $this->getJSON($url);
		}

		$this->commits = array_merge($this->commits, $commit_list);
	}

	private function parseRepoJSON($json) {
		return
			[
				'id' => $json->{'id'},
				'name' => $json->{'name'},
				'full_name' => $json->{'full_name'},
				'owner' => $json->{'owner'}->{'login'},
				'owner_id' => $json->{'owner'}->{'id'},
				'owner_avatar-url' => $json->{'owner'}->{'avatar_url'},
				'owner_gravatar-id' => $json->{'owner'}->{'gravatar_id'},
				'url' => $json->{'html_url'},
				'language' => $json->{'language'},
				'url' => $json->{'html_url'},
				'creation' => DateTime::createFromFormat(DateTime::ISO8601, $json->{'created_at'}),
				'size' => $json->{'size'},
				'default_branch' => $json->{'default_branch'},
				'commits_url' => str_replace('{/sha}', '', $json->{'commits_url'}),
			];
	}

	private function parseCommitJSON($repo, $json) {
		return
			[
				'sha' => $json->{'sha'},
				'author_name' => $json->{'commit'}->{'author'}->{'name'},
				'author_mail' => $json->{'commit'}->{'author'}->{'email'},
				'author_login' => $json->{'author'}->{'login'},
				'author_id' => $json->{'author'}->{'id'},
				'sha' => $json->{'sha'},
				'message' => $json->{'commit'}->{'message'},
				'repository' => $repo,
				'date' => DateTime::createFromFormat(DateTime::ISO8601, $json->{'commit'}->{'author'}->{'date'}),
			];
	}

	private function save() {
		$this->output_flushed("Start saving data");

		$save = serialize(
			[
				'repositories' => $this->repositories,
				'commits' => $this->commits,
			]);

		file_put_contents(self::FILE_RAW_DATA, $save);

		$this->output_flushed('Finished saving data');
	}

	public function output_flushed_clear()
	{
		if (session_status() !== PHP_SESSION_ACTIVE) session_start();

		$_SESSION[self::PROGRESS_SESSION_COOKIE] = '';
		session_commit();
	}

	public function output_flushed($txt)
	{
		if (session_status() !== PHP_SESSION_ACTIVE) session_start();

		$_SESSION[self::PROGRESS_SESSION_COOKIE] .= '[' . date('H:i.s') . '] ' . $txt . "\r\n";
		session_commit();
	}

	public function loadData() {
		$data = unserialize(file_get_contents(self::FILE_RAW_DATA));

		$this->repositories = $data['repositories'];
		$this->commits = $data['commits'];
	}

	public function generate($year) {
		$ymap = $this->generateYearMap($year);  // unused on purpose (template.php needs it)

		$ymapmax = min($this->getMaxCommitCount(), self::COMMITCOUNT_COLOR_UPPERLIMIT);  // unused on purpose (template.php needs it)

		ob_start();
		include('template.php');
		$returned = ob_get_contents();
		ob_end_clean();

		return $returned;
	}

	public function generateAndSave() {
		$result = '';

		foreach($this->getYears() as $year) {
			$result.= $this->generate($year);
			$result.= '<br />';
		}

		$this->generateCommitMap();

		file_put_contents(self::FILE_FINISHED_DATA,
			serialize(
				[
					'creation' => new DateTime(),
					'total' => count($this->commits),
					'repos' => count($this->repositories),
					'streak' => $this->getLongestStreak(),
					'streak_start' => $this->getLongestStreakStart(),
					'streak_end' => $this->getLongestStreakEnd(),
					'max_commits' => $this->getMaxCommits(),
					'max_commits_date' => $this->getMaxCommitsDate(),
					'avg_commits' => $this->getAvgCommits(),
					'start' => $this->startdate,
					'end' => $this->enddate,
					'content' => $result,
				]));

		return $result;
	}

	private function generateCommitMap() {
		$this->commitmap = array();

		$this->startdate = $this->getStartDate();
		$this->enddate = $this->getEndDate();

		$date = clone $this->startdate;
		while($date < $this->enddate) {
			$this->commitmap[$date->format('Y-m-d')] = 0;

			$date = $date->modify("+1 day");
		}

		foreach	($this->commits as $commit) {
			if(array_key_exists($commit['date']->format('Y-m-d'), $this->commitmap))
				$this->commitmap[$commit['date']->format('Y-m-d')]++;
		}
	}

	private function getStartDate() {
		$date = $this->commits[0]['date'];

		foreach($this->commits as $commit) {
			if ($commit['date'] < $date) {
				$date = clone $commit['date'];
			}
		}

		return new DateTime($date->format('Y-m-d'));
	}

	private function getEndDate() {
		$date = $this->commits[0]['date'];

		foreach($this->commits as $commit) {
			if ($commit['date'] > $date) {
				$date = clone $commit['date'];
			}
		}

		return new DateTime($date->format('Y-m-d'));
	}

	private function getCommitsForDate($d) {
		$v = $d->format('Y-m-d');
		if (array_key_exists($v, $this->commitmap))
			return $this->commitmap[$d->format('Y-m-d')];
		else
			return 0;
	}

	private function getLongestStreak() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$streak_curr = 0;
		$streak_max = 0;

		while ($curr <= $end) {
			if ($this->getCommitsForDate($curr) > 0) {
				$streak_curr++;
			} else {
				$streak_max = max($streak_max, $streak_curr);
				$streak_curr = 0;
			}

			$curr = $curr->modify('+1 day');
		}

		$streak_max = max($streak_max, $streak_curr);

		return $streak_max;
	}

	private function getLongestStreakStart() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$streak_curr_start = clone $curr;
		$streak_max_start = null;

		$streak_curr = 0;
		$streak_max = 0;

		while ($curr <= $end) {
			if ($this->getCommitsForDate($curr) > 0) {
				$streak_curr++;
			} else {
				if ($streak_curr > $streak_max) {
					$streak_max = $streak_curr;
					$streak_max_start = clone $streak_curr_start;
				}

				$streak_curr = 0;
				$streak_curr_start = clone $curr;
			}

			$curr = $curr->modify('+1 day');
		}

		if ($streak_curr > $streak_max) {
			$streak_max_start = clone $streak_curr_start;
		}

		return $streak_max_start;
	}

	private function getLongestStreakEnd() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$streak_max_end = null;

		$streak_curr = 0;
		$streak_max = 0;

		while ($curr <= $end) {
			if ($this->getCommitsForDate($curr) > 0) {
				$streak_curr++;
			} else {
				if ($streak_curr > $streak_max) {
					$streak_max = $streak_curr;
					$streak_max_end = clone $curr;
				}

				$streak_curr = 0;
			}

			$curr = $curr->modify('+1 day');
		}

		if ($streak_curr > $streak_max) {
			$streak_max_end = clone $curr;
		}

		return $streak_max_end;
	}

	private function getMaxCommits() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$max = 0;

		while ($curr <= $end) {
			$max = max($max, $this->getCommitsForDate($curr));

			$curr = $curr->modify('+1 day');
		}

		return $max;
	}

	private function getMaxCommitsDate() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$max = 0;
		$max_date = null;

		while ($curr <= $end) {
			$c = $this->getCommitsForDate($curr);
			if ($c >=  $max) {
				$max = $c;
				$max_date = clone $curr;
			}
			$max = max($max, $this->getCommitsForDate($curr));

			$curr = $curr->modify('+1 day');
		}

		return $max_date;
	}

	private function getAvgCommits() {
		/* @var $curr DateTime */
		/* @var $end DateTime */
		$curr = clone $this->startdate;
		$end = clone $this->enddate;

		$max = array();

		while ($curr <= $end) {
			$max[] = $this->getCommitsForDate($curr);

			$curr = $curr->modify('+1 day');
		}

		$sum = array_sum($max);
		$count = count($max);

		return $sum / $count;
	}

	public function loadFinishedContent() {
		$data = unserialize(file_get_contents(self::FILE_FINISHED_DATA));
		return $data['content'];
	}

	public function loadFinishedData() {
		$data = unserialize(file_get_contents(self::FILE_FINISHED_DATA));
		return $data;
	}

	private function getMaxCommitCount() {
		$max = 0;

		foreach($this->getYears() as $year) {
			$max = max($max, max($this->generateYearMap($year)));
		}

		return $max;
	}

	private function generateYearMap($year) {
		$ymap = array();

		$date = new DateTime($year . '-01-01');
		while($date->format('Y') == $year) {
			$ymap[$date->format('Y-m-d')] = 0;

			$date = $date->modify("+1 day");
		}

		foreach	($this->commits as $commit) {
			if(array_key_exists($commit['date']->format('Y-m-d'), $ymap))
				$ymap[$commit['date']->format('Y-m-d')]++;
		}

		return $ymap;
	}

	public function getYears() {
		$years = array();

		foreach	($this->commits as $commit) {
			if(! in_array($commit['date']->format('Y'), $years))
				$years[] = $commit['date']->format('Y');
		}

		asort($years);

		return $years;
	}

	public function addSecondaryUsername($sun)
	{
		$this->sec_username[] = $sun;
	}

	public function addSecondaryRepository($sre)
	{
		$this->sec_repo[] = $sre;
	}
}