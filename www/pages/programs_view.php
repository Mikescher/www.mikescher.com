<!DOCTYPE html>
<html lang="en">
<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/programs.php');
require_once (__DIR__ . '/../internals/ParsedownCustom.php');

$internalname = $OPTIONS['id'];

$prog = Programs::getProgramByInternalName($internalname);

if ($prog === NULL) httpError(404, 'Program not found');


?>
<head>
	<meta charset="utf-8">
	<title>Mikescher.com - <?php echo $prog['name']; ?></title>
	<link rel="icon" type="image/png" href="/data/images/favicon.png"/>
	<link rel="canonical" href="https://www.mikescher.com/programs/view/<?php echo $prog['internal_name']; ?>"/>
	<?php printCSS(); ?>
</head>
<body>
<div id="mastercontainer">

	<?php $HEADER_ACTIVE = 'programs'; include (__DIR__ . '/../fragments/header.php'); ?>

	<div id="content" class="content-responsive">

		<div class="blockcontent">

			<div class="prgv_content">

				<div class="contentheader" id="prgv_header"><h1><?php echo htmlspecialchars($prog['name']); ?></h1><hr/></div>

				<div class="prgv_top">
					<div class="prgv_left"><img src="<?php echo $prog['mainimage_url']; ?>" alt="Thumbnail (<?php echo $prog['name'] ?>)" /></div>
					<div class="prgv_right">
						<div class="prgv_right_key"   style="grid-row:1">Name:</div>
						<div class="prgv_right_value" style="grid-row:1"><a href="<?php echo $prog['url']; ?>"><?php echo htmlspecialchars($prog['name']) ?></a></div>

						<div class="prgv_right_key"   style="grid-row:2">Language:</div>
						<div class="prgv_right_value" style="grid-row:2"><?php echo htmlspecialchars($prog['prog_language']) ?></div>

						<?php if ($prog['license'] !== null): ?>
                        <div class="prgv_right_key"   style="grid-row:3">License:</div>
                        <div class="prgv_right_value" style="grid-row:3"><?php echo '<a href="'.Programs::getLicenseUrl($prog['license']).'">'.$prog['license'].'</a>' ?></div>
						<?php endif; ?>

						<div class="prgv_right_key"   style="grid-row:4">Category:</div>
						<div class="prgv_right_value" style="grid-row:4"><?php echo htmlspecialchars($prog['category']) ?></div>

						<div class="prgv_right_key"   style="grid-row:5">Date:</div>
						<div class="prgv_right_value" style="grid-row:5"><?php echo htmlspecialchars($prog['add_date']) ?></div>

						<div class="prgv_right_comb"  style="grid-row:6">
							<?php
							foreach (Programs::getURLs($prog) as $xurl)
							{
								echo '<a class="iconbutton '.$xurl['css'].'" href="'.$xurl['href'].'">';
								echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">';
								echo '<use xlink:href="/data/images/icons.svg#'.$xurl['svg'].'"/>';
								echo '</svg>';
								echo '<span>'.$xurl['caption'].'</span>';
								echo '</a>';
							}
							?>
						</div>

						<div class="prgv_right_comb prgv_right_lang" style="grid-row:8">
							<?php
							foreach (explode('|', $prog['ui_language']) as $lang)
							{
								echo '<img src="'.convertLanguageToFlag($lang).'" title="'.$lang.'" alt="'.$lang[0].'" />' . "\n";
							}
							?>
						</div>
					</div>
				</div>

				<hr class="prgv_sep" />

				<div class="prgv_center base_markdown">
					<?php
					$pd = new ParsedownCustom();
					echo $pd->text(Programs::getProgramDescription($prog));
					?>
				</div>

			</div>

		</div>

	</div>

	<?php include (__DIR__ . '/../fragments/footer.php');  ?>

</div>
</body>
</html>