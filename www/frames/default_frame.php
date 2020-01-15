<!DOCTYPE html>

<?php

require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $FRAME_OPTIONS->title; ?></title>
	<meta name="google-site-verification" content="pZOhmjeJcQbRMNa8xRLam4dwJ2oYwMwISY1lRKreSSs"/>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<?php
    if ($FRAME_OPTIONS->canonical_url !== null) echo '<link rel="canonical" href="'.$FRAME_OPTIONS->canonical_url.'"/>';
	foreach ($FRAME_OPTIONS->stylesheets as $cssfile) echo '<link rel="stylesheet" href="' . $cssfile . '"/>';
	foreach ($FRAME_OPTIONS->scripts as $scriptfile)
	{
		if ($scriptfile[1]) echo '<script src="' . $scriptfile[0]	 . '" defer/>';
		else                echo '<script src="' . $scriptfile[0]	 . '" type="text/javascript" ></script>';
	}
    ?>
</head>
<body>
<div id="mastercontainer">

    <div id="headerdiv">
        <div class="logowrapper">
            <a href="/"><img class="logo" src="/data/images/logo.png" alt="Mikescher.com Logo" /></a>
        </div>

        <div class="tabrow">
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'home')     echo 'tab_active'; ?>" href="/">Home</a>
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'euler')    echo 'tab_active'; ?>" href="/blog/1/Project_Euler_with_Befunge">Project Euler</a>
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'blog')     echo 'tab_active'; ?>" href="/blog">Blog</a>
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'programs') echo 'tab_active'; ?>" href="/programs">Programs</a>
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'webapps')  echo 'tab_active'; ?>" href="/webapps">Tools</a>
			<?php if ($SITE->isLoggedInByCookie()): ?><a class="tab tab_admin" href="/admin">Admin</a><?php endif; ?>
            <a class="tab <?php if ($FRAME_OPTIONS->activeHeader === 'about')    echo 'tab_active'; ?>" href="/about">About</a>
            <div class="tab_split" ></div>
			<?php if ($SITE->isLoggedInByCookie()): ?><a class="tab tab_logout" href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-8 0 40 32"><path d="m 18,24 0,4 -14,0 0,-24 14,0 0,4 4,0 0,-8 -22,0 0,32 22,0 0,-8 z m -6,-4.003 0,-8 12,0 0,-4 8,8 -8,8 0,-4 z"></path></svg></a><?php endif; ?>
            <a class="tab tab_github" href="https://github.com/Mikescher/">Github</a>
        </div>

    </div>

	<div id="content" class="<?php echo join(' ', $FRAME_OPTIONS->contentCSSClasses); ?>">
		<?php echo $FRAME_OPTIONS->raw; ?>
	</div>

	<div id="footerdiv" class="content-responsive">
		<hr />
		made with vanilla PHP and MySQL<span class="footerspan2">, no frameworks, no bootstrap, no unnecessary* javascript</span>
	</div>

</div>
</body>
</html>