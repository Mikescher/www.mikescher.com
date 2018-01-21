<?php

require_once 'SingleCommitInfo.php';
require_once 'Utils.php';

class ConnectionGithub
{
	const API_OAUTH_AUTH  = 'https://github.com/login/oauth/authorize?client_id=%s';
	const URL_OAUTH_TOKEN = 'https://github.com/login/oauth/access_token?client_id={id}&client_secret={secret}&code={code}';

	const API_RATELIMIT        = 'https://api.github.com/rate_limit';
	const API_REPOSITORIESLIST = 'https://api.github.com/users/{user}/repos?page={page}&per_page=100';
	const API_COMMITSLIST      = 'https://api.github.com/repos/{repo}/commits?per_page=100&page={page}&author={author}';

	/* @var string */
	private $token;

	/* @var string */
	private $owner;

	/**
	 * @param $owner ExtendedGitGraph
	 */
	public function __construct($owner) {
		$this->owner = $owner;
	}

	public function setAPIToken($token) {
		$this->token = $token;
	}

	public function queryAPIToken($client_id, $client_secret) {
		$url = Utils::sharpFormat(self::URL_OAUTH_TOKEN, ['id'=>$client_id, 'secret'=>$client_secret, 'code'=>'egh']);
		$result = file_get_contents($url);

		$result = str_replace('access_token=', '', $result);
		$result = str_replace('&scope=&token_type=bearer', '', $result);

		$this->setAPIToken($result);
	}

	/**
	 * @param $cfg EGHRemoteConfig
	 * @return SingleCommitInfo[]
	 */
	public function getDataUser($cfg)
	{
		$repos = $this->listRepositoriesByUser($cfg->Param);

		$result = [];
		foreach ($repos as $repo)
		{
			$commits = $this->listCommitsFromRepo($repo, $cfg->Author);
			foreach ($commits as $c) $result []= $c;
		}

		return $result;
	}


	/**
	 * @param $cfg EGHRemoteConfig
	 * @return SingleCommitInfo[]
	 */
	public function getDataRepository($cfg)
	{
		return $this->listCommitsFromRepo($cfg->Param, $cfg->Author);
	}

	/**
	 * @param $user string
	 * @return string[]
	 */
	private function listRepositoriesByUser($user)
	{
		$result = [];

		$page = 1;
		$url = Utils::sharpFormat(self::API_REPOSITORIESLIST, ['user'=>$user, 'page'=>$page, 'token'=>$this->token]);

		$json = $this->getJSON($url);

		while (! empty($json)) {
			foreach ($json as $result_repo) {
				$result []= $result_repo->{'full_name'};
				$this->owner->out("Found Repo: " . $result_repo->{'full_name'});
			}

			$page++;
			$url = Utils::sharpFormat(self::API_REPOSITORIESLIST, ['user'=>$user, 'page'=>$page, 'token'=>$this->token]);
			$json = $this->getJSON($url);
		}

		return $result;
	}

	/**
	 * @param $repo string
	 * @param $user string
	 * @return SingleCommitInfo[]
	 */
	private function listCommitsFromRepo($repo, $user)
	{
		$page = 1;
		$url = Utils::sharpFormat(self::API_COMMITSLIST, ['repo'=>$repo, 'author'=>$user, 'page'=>$page, 'token'=>$this->token]);

		$result = $this->getJSON($url);

		$commit_list = [];

		while (! empty($result)) {
			foreach ($result as $rc) $commit_list[] = new SingleCommitInfo(DateTime::createFromFormat(DateTime::ISO8601, $rc->{'commit'}->{'author'}->{'date'}), 'github', $user, $repo);
			$this->owner->out("Found " . count($result) . " Commits in " . $repo);

			$page++;
			$url = Utils::sharpFormat(self::API_COMMITSLIST, [ 'repo'=>$repo, 'author'=>$user, 'page'=>$page, 'token'=>$this->token ]);
			$result = $this->getJSON($url);
		}

		return $commit_list;
	}
	public function getJSON($url) {
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
			$options  =
				[
					'http'  =>
						[
							'user_agent' => $_SERVER['HTTP_USER_AGENT'],
							'header' => 'Authorization: token ' . $this->token,
						],
					'https' =>
						[
							'user_agent' => $_SERVER['HTTP_USER_AGENT'],
							'header' => 'Authorization: token ' . $this->token,
						],
				];
		} else {
			$options  =
				[
					'http' =>
						[
							'user_agent' => 'ExtendedGitGraph_for_mikescher.com',
							'header' => 'Authorization: token ' . $this->token,
						],
					'https' =>
						[
							'user_agent' => 'ExtendedGitGraph_for_mikescher.com',
							'header' => 'Authorization: token ' . $this->token,
						],
				];
		}

		$context  = stream_context_create($options);

		$response = @file_get_contents($url, false, $context);

		if ($response === false)
		{
			$this->owner->out("Error recieving json: '" . $url . "'");
			return [];
		}

		return json_decode($response);
	}

}