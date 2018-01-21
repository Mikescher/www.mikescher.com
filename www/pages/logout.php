<?php
require_once (__DIR__ . '/../internals/base.php');
global $OPTIONS;

$redirect = $OPTIONS['logout_target'];

clearLoginCookie();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Mikescher.com - Logout</title>
    <link rel="icon" type="image/png" href="/data/images/favicon.png"/>
    <link rel="canonical" href="https://www.mikescher.com/logout"/>
    <meta http-equiv="refresh" content="1; url=<?php echo $redirect; ?>" />
</head>
<body>
You have been logged out
<script>
    setTimeout(function () { window.location.href = "<?php echo $redirect; ?>"; }, 1000);
</script>
</body>
</html>
