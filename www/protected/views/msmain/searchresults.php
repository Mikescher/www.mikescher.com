<?php
/* @var $this MsMainController */
/* @var $searchstring string */
/* @var $result array() */

$this->pageTitle = 'Search - ' . $searchstring;
$this->searchvalue = $searchstring;

$this->breadcrumbs=
	[
		'Search'
	];

?>

<div class="container">
	<div class="sresults_main well">
		<span class="sresults_info"><?php echo count($result); ?> results found for "<?php echo $searchstring; ?>"</span>

		<?php foreach($result as $section): ?>
			<div class="sresults_section">
				<?php if (! is_null($section['Image'])): ?>
					<img class="sresults_image pull-left" src="<?php echo $section['Image'];?>">
				<?php endif; ?>
				<h3 class="sresults_caption"><a href="<?php echo $section['Link'];?>"><?php echo $section['Name'];?></a></h3>
				<?php if (! is_null($section['Description'])): ?>
				<p class="sresults_desc"><?php echo $section['Description'];?></p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>