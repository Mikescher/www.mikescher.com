<div id="headerdiv">
	<div class="logowrapper">
		<a href="/"><img class="logo" src="/data/images/logo.png" alt="Mikescher.com Logo" /></a>
	</div>

	<div class="tabrow">
		<a class="tab <?php if ($HEADER_ACTIVE === 'home')     echo 'tab_active'; ?>" href="/">Home</a>
		<a class="tab <?php if ($HEADER_ACTIVE === 'euler')    echo 'tab_active'; ?>" href="/blog/1/Project_Euler_with_Befunge">Project Euler</a>
		<a class="tab <?php if ($HEADER_ACTIVE === 'blog')     echo 'tab_active'; ?>" href="/blog">Blog</a>
        <a class="tab <?php if ($HEADER_ACTIVE === 'programs') echo 'tab_active'; ?>" href="/programs">Programs</a>
        <a class="tab <?php if ($HEADER_ACTIVE === 'webapps')  echo 'tab_active'; ?>" href="/webapps">Tools</a>
        <?php if (isLoggedInByCookie()): ?><a class="tab tab_admin" href="/admin">Admin</a><?php endif; ?>
		<a class="tab <?php if ($HEADER_ACTIVE === 'about')    echo 'tab_active'; ?>" href="/about">About</a>
		<div class="tab_split" ></div>
		<?php if (isLoggedInByCookie()): ?><a class="tab tab_logout" href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-8 0 40 32"><path d="m 18,24 0,4 -14,0 0,-24 14,0 0,4 4,0 0,-8 -22,0 0,32 22,0 0,-8 z m -6,-4.003 0,-8 12,0 0,-4 8,8 -8,8 0,-4 z"></path></svg></a><?php endif; ?>
        <a class="tab tab_github" href="https://github.com/Mikescher/">Github</a>
	</div>

</div>