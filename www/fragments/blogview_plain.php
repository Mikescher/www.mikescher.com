<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
?>

<div class="boxedcontent blogcontent_plain">

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
		<?php echo nl2br(htmlspecialchars(Blog::getPostFragment($post))); ?>
	</div>

</div>