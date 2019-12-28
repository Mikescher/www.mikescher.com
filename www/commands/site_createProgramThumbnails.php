<?php

global $OPTIONS;

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/books.php');
require_once (__DIR__ . '/../internals/programs.php');

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<title>Mikescher.com - AdminExec</title>';
echo '<link rel="icon" type="image/png" href="/data/images/favicon.png"/>';
echo '<link rel="canonical" href="https://www.mikescher.com/logout"/>';
echo '<meta http-equiv="refresh" content="3;url=/admin;"/>';
echo '</head>';
echo '<body>';

foreach (Programs::listAll() as $prog)
{
	echo 'Create preview for ' . $prog['name'] . '<br/>' . "\n";
	Programs::createPreview($prog);
}
echo 'Finished.' . '<br/>' . "\n";

echo '<script>setTimeout(function () { window.location.href = "/admin"; }, 3000);</script>';
echo '</body>';
echo '</html>';
