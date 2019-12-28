<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

global $CONFIG;

if (isset($_GET['clear']))
{
	if (key_exists($CONFIG['extendedgitgraph']['session_var'], $_SESSION)) $_SESSION[$CONFIG['extendedgitgraph']['session_var']] = '';
}

if (key_exists($CONFIG['extendedgitgraph']['session_var'], $_SESSION))
	echo $_SESSION[$CONFIG['extendedgitgraph']['session_var']];
else
	echo '[[ NO SESSION STARTED ]]';


return;