<?php

require_once 'Utils.php';
require_once 'EGGDatabase.php';
require_once 'RemoteSource.php';

class GiteaConnection extends StandardGitConnection
{
	const API_BASE_URL     = '/api/v1';

    const API_USER_REPO_LIST = '/users/{user}/repos?page={page}&limit={limit}';
    const API_USER_ORG_LIST  = '/orgs?page={page}&limit={limit}';
	const API_BRANCH_LIST    = '/repos/{repo}/branches?page={page}&limit={limit}';
	const API_COMMIT_LIST    = '/repos/{repo}/commits?sha={sha}&limit={limit}';

	/** @var string $url */
	private $url;

	/** @var string $username */
	private $username;

	/** @var string $password */
	private $password;

	/**
	 * @param ILogger $logger
	 * @param string $name
	 * @param string $url
	 * @param string $filter
	 * @param string[] $exclusions
	 * @param string $username
	 * @param string $password
	 */
	public function __construct(ILogger $logger, string $name, string $url, string $filter, array $exclusions, string $username, string $password)
	{
		parent::__construct($logger, $name, $filter, $exclusions);

		$this->url          = $url;
		$this->username     = $username;
		$this->password     = $password;
	}

	/** @inheritDoc */
	protected function preUpdate()
	{
		//
	}

	/** @inheritDoc */
	protected function postUpdate()
	{
		//
	}

    /** @inheritDoc */
    protected function queryOrganizations($page)
    {
        $url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_USER_ORG_LIST), ['page'=>$page, 'limit'=>64 ]);
        return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
    }

	/** @inheritDoc */
	protected function queryRepositories($user, $page)
	{
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_USER_REPO_LIST), ['user'=>$user, 'page'=>$page, 'limit'=>64 ]);
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
	}

	/** @inheritDoc */
	protected function queryBranches($reponame, $page)
	{
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_BRANCH_LIST), ['repo'=>$reponame, 'page'=>$page, 'limit'=>64]);
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
	}

	/** @inheritDoc */
	protected function queryCommits($reponame, $branchname, $startsha)
	{
		$url = Utils::sharpFormat(Utils::urlCombine($this->url, self::API_BASE_URL, self::API_COMMIT_LIST), [ 'repo'=>$reponame, 'sha'=>$startsha, 'limit'=>1024 ]);
		return Utils::getJSONWithTokenBasicAuth($this->logger, $url, $this->username, $this->password);
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
    protected function readOrganization($data)
    {
        return
            [
                'id'        => $data->{'id'},
                'full_name' => $data->{'full_name'},
                'key'       => $data->{'username'},
            ];
    }

	/** @inheritDoc */
	protected function readBranch($data)
	{
		return
		[
			'name' => $data->{'name'},
			'sha'  => $data->{'commit'}->{'id'},
		];
	}

	/** @inheritDoc */
	protected function readCommit($data)
	{
		return
		[
			'sha'              => $data->{'commit'}->{'tree'}->{'sha'},

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
	public function toString() { return "[Gitea|".$this->url."|".$this->filter."]"; }
}