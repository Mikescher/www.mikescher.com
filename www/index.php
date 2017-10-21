<?php

$path      = strtolower(parse_url($_SERVER['REQUEST_URI'])['path']);
$pathparts = preg_split('@/@', $path, NULL, PREG_SPLIT_NO_EMPTY);
$partcount = count($pathparts);

global $OPTIONS;

// [/]
if ($partcount == 0)
{
	$OPTIONS = [];
	include 'pages/main.php';
	return;
}

// [programs/]
if ($partcount == 1 && $pathparts[0] == 'programs')
{
	$OPTIONS = [];
	include 'pages/programs_list.php';
	return;
}

// [programs/cat/<categoryfilter>]
if ($partcount == 3 && $pathparts[0] == 'programs' && $pathparts[1] == 'cat')
{
	$OPTIONS = [ 'categoryfilter' => $pathparts[2] ];
	include 'pages/programs_list.php';
	return;
}

// [programs/view/<id>]
if ($partcount == 3 && $pathparts[0] == 'programs' && $pathparts[1] == 'view')
{
	$OPTIONS = [ 'id' => $pathparts[2] ];
	include 'pages/programs_view.php';
	return;
}

// [programs/download/<id>]
if ($partcount == 3 && $pathparts[0] == 'programs' && $pathparts[1] == 'download')
{
	$OPTIONS = [ 'id' => $pathparts[2] ];
	include 'pages/programs_download.php';
	return;
}

// [log/]
if ($partcount == 1 && $pathparts[0] == 'log')
{
	$OPTIONS = [ 'id' => -1 ];
	include 'pages/log.php';
	return;
}

// [log/<id>]
if ($partcount == 2 && $pathparts[0] == 'log')
{
	$OPTIONS = [ 'id' => $pathparts[1] ];
	include 'pages/log.php';
	return;
}

// [update.php]
if ($partcount == 1 && $pathparts[0] == 'update.php')
{
	$OPTIONS = [ 'name' => '' ];
	include 'pages/updatecheck.php';
	return;
}

// [update.php/<name>]
if ($partcount == 2 && $pathparts[0] == 'update.php')
{
	$OPTIONS = [ 'name' => $pathparts[1] ];
	include 'pages/updatecheck.php';
	return;
}

// [update/]
if ($partcount == 1 && $pathparts[0] == 'update')
{
	$OPTIONS = [ 'name' => '' ];
	include 'pages/updatecheck.php';
	return;
}

// [update/<name>]
if ($partcount == 2 && $pathparts[0] == 'update')
{
	$OPTIONS = [ 'name' => $pathparts[1] ];
	include 'pages/updatecheck.php';
	return;
}

// [blog/]
if ($partcount == 1 && $pathparts[0] == 'blog')
{
	$OPTIONS = [];
	include 'pages/blog_list.php';
	return;
}

// [blog/<id>]
if ($partcount == 2 && $pathparts[0] == 'blog')
{
	$OPTIONS = [ 'id' => $pathparts[1] ];
	include 'pages/blog_view.php';
	return;
}

// [blog/<id>/<name>]
if ($partcount == 3 && $pathparts[0] == 'blog')
{
	$OPTIONS = [ 'id' => $pathparts[1], 'subview' => '' ];
	include 'pages/blog_view.php';
	return;
}

// [blog/<id>/<name>/<subview>]
if ($partcount == 4 && $pathparts[0] == 'blog')
{
	$OPTIONS = [ 'id' => $pathparts[1], 'subview' => $pathparts[3] ];
	include 'pages/blog_view.php';
	return;
}

// [msmain/admin/egh/<commandcode>]
if ($partcount == 4 && $pathparts[0] == 'msmain' && $pathparts[1] == 'admin' && $pathparts[2] == 'egh')
{
	$OPTIONS = [ 'commandcode' => $pathparts[3] ];
	include 'pages/egh.php';
	return;
}

die("Invalid path:" . $path); //TODO