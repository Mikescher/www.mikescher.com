<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/webapp.php');

$allapps = WebApps::listAllNewestFirst();

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Tools</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/webapps"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

<?php $HEADER_ACTIVE='webapps'; include (__DIR__ . '/../fragments/header.php');  ?>

<div id="content" class="content-responsive">

	<div class="blockcontent">

		<div class="contentheader"><h1>Online tools and web apps</h1><hr/></div>

		<div class='webapplistelem_container'>
			<?php

			foreach ($allapps as $post)
			{
				echo "<a class='webapplistelem' href='" . $post['url'] . "'>\n";
				echo "<div class='wle_date'>"  . $post['date'] . "</div>\n";
				echo "<div class='wle_title'>"  . $post['title'] . "</div>\n";
				echo "</a>\n";
			}

			?>
		</div>

	</div>

</div>

<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>