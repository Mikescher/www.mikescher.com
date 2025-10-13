<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'About';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/about';
$FRAME_OPTIONS->activeHeader = 'about';
?>

<div class="aboutcontent">

    <div class="contentheader"><h1>About mikescher.com</h1><hr/></div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">About me</div>

        <div class="bc_data">

            <p>Welcome to my Mikescher.com</p>
            <p>This is my personal homepage, I use it to upload programs I have written, web serials I have style-setted and sometimes for a little bit of blogging.</p>
            <p>Its mostly just a collection of stuff I wanted to put only, but I guess thats the core of most personal homepages</p>

        </div>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">My git timeline</div>

        <div class="bc_data about_egg_container">

			<?php
			$FRAME_OPTIONS->addScript('/data/javascript/extendedgitgraph.js', true);
            echo $SITE->modules->ExtendedGitGraph()->get();
            ?>

        </div>

    </div>

    <!-- - - - - - - - - - - - - - - - - - - - - -->

    <div class="boxedcontent">
        <div class="bc_header">Other addresses</div>

        <div class="bc_data about_circles">

            <a class="iconbutton_light" href="https://github.com/Mikescher">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#github"></use>
                </svg>
                <span>Github</span>
            </a>
            <a class="iconbutton_light" href="https://www.goodreads.com/C4terpillar">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#goodreads"></use>
                </svg>
                <span>Goodreads</span>
            </a>
            <a class="iconbutton_light" href="https://stackoverflow.com/users/1761622/mikescher">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#stackoverflow"></use>
                </svg>
                <span>Stackoverflow</span>
            </a>
            <a class="iconbutton_light" href="https://www.reddit.com/user/M1kescher/">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#reddit"></use>
                </svg>
                <span>Reddit</span>
            </a>
            <a class="iconbutton_light" href="http://www.delphipraxis.net/members/46235-mikescher.html">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#delphipraxis"></use>
                </svg>
                <span>Delphi-Praxis</span>
            </a>
            <a class="iconbutton_light" href="mailto:website_mailto@mikescher.com">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#email"></use>
                </svg>
                <span>E-Mail</span>
            </a>
            <a class="iconbutton_light" href="https://www.linkedin.com/in/mike-schw%C3%B6rer-2274b522a/">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#linkedin"></use>
                </svg>
                <span>LinkedIn</span>
            </a>
            <a class="iconbutton_light" href="https://lichess.org/@/Mikescher">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
                    <use xlink:href="/data/images/icons.svg#lichess"></use>
                </svg>
                <span>Lichess</span>
            </a>

        </div>

    </div>

</div>
