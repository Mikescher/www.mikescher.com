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
    <link rel="stylesheet" href="/data/css/styles.css" />
</head>
<body>
<div id="mastercontainer">

    <div id="headerdiv">
        <div class="logowrapper">
            <a href="/"><img class="logo" src="/data/images/logo.png" alt="Mikescher.com Logo" /></a>
        </div>

        <div class="tabrow">
            <a class="tab" href="/">Home</a>
            <a class="tab" href="/blog/1/Project_Euler_with_Befunge">Project Euler</a>
            <a class="tab" href="/blog">Blog</a>
            <a class="tab" href="/programs">Programs</a>
            <a class="tab" href="/webapps">Tools</a>
            <a class="tab" href="/about">About</a>
            <div class="tab_split" ></div>
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