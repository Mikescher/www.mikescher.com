<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;


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

foreach ($SITE->modules->Programs()->listAll() as $prog)
{
	echo 'Create preview for ' . $prog['name'] . '<br/>' . "\n";

	try {
		$SITE->modules->Programs()->createPreview($prog);
	} catch (Exception $e) {
		echo '<strong>Failed to create preview for ' . $prog['name'] . ':' . $e->getMessage() . '</strong><br/>' . "\n";
	}

}
echo 'Finished.' . '<br/>' . "\n";

echo '<script>setTimeout(function () { window.location.href = "/admin"; }, 3000);</script>';
echo '</body>';
echo '</html>';
