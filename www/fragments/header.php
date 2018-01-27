<div id="headerdiv">
	<div class="logowrapper">
		<img class="logo" src="/data/images/logo.png" />
	</div>

	<div class="tabrow">
		<a class="tab <?php if ($HEADER_ACTIVE === 'home')     echo 'tab_active'; ?>" href="/">Home</a>
		<a class="tab <?php if ($HEADER_ACTIVE === 'euler')    echo 'tab_active'; ?>" href="/blog/1/Project_Euler_with_Befunge">Project Euler</a>
		<a class="tab <?php if ($HEADER_ACTIVE === 'blog')     echo 'tab_active'; ?>" href="/blog">Blog</a>
        <a class="tab <?php if ($HEADER_ACTIVE === 'programs') echo 'tab_active'; ?>" href="/programs">Programs</a>
        <?php if (isLoggedInByCookie()): ?><a class="tab tab_admin" href="/admin">Admin</a><?php endif; ?>
		<a class="tab <?php if ($HEADER_ACTIVE === 'about')    echo 'tab_active'; ?>" href="/about">About</a>
		<div class="tab_split" ></div>
		<?php if (isLoggedInByCookie()): ?><a class="tab tab_logout" href="/logout">{Logout}</a><?php endif; ?>
        <a class="tab tab_github" href="https://github.com/Mikescher/">Github</a>
	</div>

</div>