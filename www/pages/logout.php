<?php
require_once (__DIR__ . '/../internals/website.php');

/** @var PageFrameOptions $FRAME_OPTIONS */ global $FRAME_OPTIONS;
/** @var URLRoute $ROUTE */ global $ROUTE;
/** @var Website $SITE */ global $SITE;
?>


<?php
$redirect = $ROUTE->parameter['logout_target'];
$SITE->clearLoginCookie();
?>

You have been logged out
<script>  setTimeout(function () { window.location.href = "<?php echo $redirect; ?>"; }, 1000);  </script>
