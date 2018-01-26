<?php if(count(get_included_files()) ==1) exit("Direct access not permitted.");

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egh/ExtendedGitGraph.php');

class MikescherGitGraph
{
	public static function create()
	{
		global $CONFIG;

		$v = new ExtendedGitGraph(__DIR__ . '/../temp/egh_cache.bin', ExtendedGitGraph::OUT_SESSION, __DIR__ . '/../temp/egh_log{num}.log');

		$v->addRemote('github-user',       null, 'Mikescher', 'Mikescher');
		//$v->addRemote('github-user',       null, 'Mikescher', 'Sam-Development');
		//$v->addRemote('github-repository', null, 'Mikescher', 'Anastron/ColorRunner');
		$v->addRemote('gitea-repository',  null, 'Mikescher', 'Mikescher/server-scripts');
		$v->addRemote('gitea-repository',  null, 'Mikescher', 'Mikescher/apache-sites');
		$v->addRemote('gitea-repository',  null, 'Mikescher', 'Mikescher/MVU_API');

		$v->setColorScheme($CONFIG['egh_theme']);

		$v->ConnectionGithub->setAPIToken($CONFIG['egh_token']);

		$v->ConnectionGitea->setURL('https://gogs.mikescher.com');

		return $v;
	}
}