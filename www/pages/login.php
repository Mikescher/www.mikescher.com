<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
global $OPTIONS;

$err = false;

if (key_exists('username', $_GET) && key_exists('password', $_GET) && key_exists('redirect', $_GET))
{
	if ($_GET['username'] === $CONFIG['admin_username'] && $_GET['password'] === $CONFIG['admin_password'])
	{
		$expires = time() + (24*60*60); // 24h
		$hash = hash('sha256', $_GET['username'] . ';' . $_GET['password']);
		setcookie('mikescher_auth', $hash, $expires);

		header('Location: ' . $_GET['redirect']);
		die();
	}
	else
	{
		$err = true;
	}
}

$redirect = $OPTIONS['login_target'];

?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - Login</title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<link rel="canonical" href="https://www.mikescher.com/login"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'login'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

		<div class="aboutcontent">

			<div class="boxedcontent">
				<div class="bc_header">Mikescher.com - Login</div>

				<div class="bc_data">

					<div class="form">
						<form id="loginform" action="/login" method="GET">

                            <?php if ($err): ?>
                            <span class="loginerror">Wrong username or password</span>
							<?php endif; ?>

							<div>
								<label for="username" class="required">Username</label>
								<input name="username" id="username" type="text">
							</div>

							<div>
								<label for="password">Password</label>
								<input name="password" id="password" type="password">
							</div>

							<div style="display: none; visibility: hidden">
								<label for="redirect">Redirect</label>
								<input name="redirect" id="redirect" type="text" value="<?php echo $redirect ?>">
							</div>

							<div>
								<button class="button" type="submit" name="yt0">Login</button>
							</div>

						</form>
					</div>


				</div>

			</div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>