<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>

<?php
$FRAME_OPTIONS->title = 'Login';
$FRAME_OPTIONS->canonical_url = 'https://www.mikescher.com/login';
$FRAME_OPTIONS->activeHeader = 'login';

$FRAME_OPTIONS->addScript('/data/javascript/ms_basic.js', true);
?>

<?php
$err = false;

if (key_exists('username', $_GET) && key_exists('password', $_GET) && key_exists('redirect', $_GET))
{
	if ($_GET['username'] === $SITE->config['admin_username'] && $_GET['password'] === $SITE->config['admin_password'])
	{
		$SITE->setLoginCookie($_GET['username'], $_GET['password']);
		$FRAME_OPTIONS->setForcedRedirect($_GET['redirect']);
		return;
	}
	else
	{
		$err = true;
	}
}

$redirect = $ROUTE->parameter['login_target'];
if (($redirect === '/' || $redirect === '') && isset($_GET['redirect'])) $redirect = $_GET['redirect'];
if (($redirect === '/' || $redirect === '')) $redirect = '/admin';
?>

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
                        <input name="username" id="username" type="text" autofocus>
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
