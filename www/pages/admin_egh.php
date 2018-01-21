<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/egh/ExtendedGitGraph.php');

$cmd = $OPTIONS['cmd'];
$secret = $OPTIONS['secret'];

if ($secret !== $CONFIG['ajax_secret'])
	die('Unauthorized.');

function create()
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

if ($cmd === 'status')
{
	if (session_status() !== PHP_SESSION_ACTIVE) session_start();

	if (key_exists('ajax_progress_egh_refresh', $_SESSION))
		echo $_SESSION['ajax_progress_egh_refresh'];
	else
		echo '[[ NO SESSION STARTED ]]';

	return;
}
else if ($cmd === 'refresh')
{
	set_time_limit(900); // 15min

	$v = create();
	$v->init();
	$v->updateFromRemotes();
	$v->generate();

	file_put_contents(__DIR__ . '/../dynamic/egh.html', $v->getAll());
}
else if ($cmd === 'redraw')
{
	set_time_limit(900); // 15min

	$v = create();
	$v->init();
	$v->updateFromCache();
	$v->generate();

	file_put_contents(__DIR__ . '/../dynamic/egh.html', $v->getAll());
}
else
{
	die('Wrong command.');
}