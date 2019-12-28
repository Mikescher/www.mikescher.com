<?php

global $CONFIG;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$svar = $CONFIG['extendedgitgraph']['session_var'];

if (isset($_GET['clear'])) if (key_exists($svar, $_SESSION)) $_SESSION[$svar] = '';

if (key_exists($svar, $_SESSION))
{
	if ($_SESSION[$svar] === '') echo '[[ NO OUTPUT ]]';
	else echo $_SESSION[$svar] === '';
}
else
{
	echo '[[ NO SESSION STARTED ]]';
}


return;