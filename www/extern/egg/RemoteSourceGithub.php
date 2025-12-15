<?php

require_once 'IConfigSource.php';
require_once 'Utils.php';
require_once 'EGGDatabase.php';
require_once 'RemoteSource.php';

class GithubConnection extends StandardGitConnection
{
	const API_OAUTH_AUTH  = 'https://github.com/login/oauth/authorize?client_id=%s';
	const URL_OAUTH_TOKEN = 'https://github.com/login/oauth/access_token?client_id={id}&client_secret={secret}&code={code}';

	const API_RATELIMIT        = 'https://api.github.com/rate_limit';
	const API_REPOSITORIESLIST = 'https://api.github.com/users/{user}/repos?page={page}&per_page=100';
	const API_COMMITSLIST      = 'https://api.github.com/repos/{repo}/commits?per_page=100&sha={sha}';
	const API_BRANCHLIST       = 'https://api.github.com/repos/{repo}/branches?page={page}';

	/** @var string $url */
	private $url;

	/** @var string $oauth_id */
	private $oauth_id;

	/** @var string $oauth_secret */
	private $oauth_secret;

	/** @var string $apitokenpath */
	private $apitokenpath;

	/** @var string $apitoken */
	private $apitoken;

	/**
	 * @param ILogger $logger
	 * @param string $name
	 * @param string $url
	 * @param string $filter
	 * @param string[] exclusions
	 * @param string $oauth_id
	 * @param string $oauth_secret
	 * @param string $apitokenpath
	 */
	public function __construct(ILogger $logger, IConfigSource $cfg, string $name, string $url, string $filter, array $exclusions, string $oauth_id, string $oauth_secret, string $apitokenpath)
	{
		parent::__construct($logger, $cfg, $name, $filter, $exclusions);

		$this->url          = $url;
		$this->oauth_id     = $oauth_id;
		$this->oauth_secret = $oauth_secret;
		$this->apitokenpath = $apitokenpath;

		if ($this->apitokenpath !== null && file_exists($this->apitokenpath))
			$this->apitoken = file_get_contents($this->apitokenpath);
		else
			$this->apitoken = null;
	}

	/**
	 * @throws Exception
	 */
	public function queryAPIToken() {
		$url = Utils::sharpFormat(self::URL_OAUTH_TOKEN, ['id'=>$this->oauth_id, 'secret'=>$this->oauth_secret, 'code'=>'egg']);
		$fullresult = $result = file_get_contents($url);

		if (Utils::startsWith($fullresult, 'error=')) throw new EGGException('GitHub Auth failed: ' . $fullresult);

		$result = str_replace('access_token=', '', $result);
		$result = str_replace('&scope=&token_type=bearer', '', $result);

		$this->logger->proclog("Updated Github API token");

		if ($result!=='' && $result !== null && $this->apitokenpath !== null)
			file_put_contents($this->apitokenpath, $result);

		$this->apitoken = $result;
	}

	/** @inheritDoc */
	protected function preUpdate()
	{
		if ($this->apitoken === null) $this->queryAPIToken();
	}

	/** @inheritDoc */
	protected function postUpdate()
	{
		//
	}

    /** @inheritDoc */
    protected function queryOrganizations($page)
    {
        throw new EGGException("Github does not support organization queries.");
    }

	/** @inheritDoc */
	protected function queryRepositories($user, $page)
	{
		$url = Utils::sharpFormat(self::API_REPOSITORIESLIST, ['user'=>$user, 'page'=>$page, 'per_page'=>$this->cfgSource->getFetchLimitRepos() ]);
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

	/** @inheritDoc */
	protected function queryBranches($reponame, $page)
	{
		$url = Utils::sharpFormat(self::API_BRANCHLIST, ['repo'=>$reponame, 'page'=>$page, 'per_page'=>$this->cfgSource->getFetchLimitBranches() ]);
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

	/** @inheritDoc */
	protected function queryCommits($reponame, $branchname, $startsha)
	{
		$url = Utils::sharpFormat(self::API_COMMITSLIST, [ 'repo'=>$reponame, 'sha'=>$startsha, 'per_page'=>$this->cfgSource->getFetchLimitCommits() ]);
		return Utils::getJSONWithTokenAuth($this->logger, $url, $this->apitoken);
	}

    /** @inheritDoc */
    protected function readOrganization($data)
    {
        return
            [
                'id'        => null, // no orgs in github
                'full_name' => null, // no orgs in github
                'key'       => null, // no orgs in github
            ];
    }

	/** @inheritDoc */
	protected function readRepository($data)
	{
		return
		[
			'full_name' => $data->{'full_name'},
			'html_url'  => $data->{'html_url'},
		];
	}

	/** @inheritDoc */
	protected function readBranch($data)
	{
		if (isset($data->{'block'})) return null;

		return
		[
			'name' => $data->{'name'},
			'sha'  => $data->{'commit'}->{'sha'},
		];
	}

	/** @inheritDoc */
	protected function readCommit($data)
	{
		return
		[
			'sha'              => $data->{'sha'},

			'author_name'      => $data->{'commit'}->{'author'}->{'name'},
			'author_email'     => $data->{'commit'}->{'author'}->{'email'},

			'committer_name'   => $data->{'commit'}->{'committer'}->{'name'},
			'committer_email'  => $data->{'commit'}->{'committer'}->{'email'},

			'message'          => $data->{'commit'}->{'message'},
			'date'             => (new DateTime($data->{'commit'}->{'author'}->{'date'}))->format("Y-m-d H:i:s"),

			'parents'          => array_map(function ($v){ return $v->{'sha'}; }, $data->{'parents'}),
		];
	}

	/** @inheritDoc  */
	public function toString() { return "[Github|".$this->filter."]"; }
}
