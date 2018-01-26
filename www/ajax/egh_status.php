<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (key_exists('ajax_progress_egh_refresh', $_SESSION))
	echo $_SESSION['ajax_progress_egh_refresh'];
else
	echo '[[ NO SESSION STARTED ]]';

return;