<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/ParsedownCustom.php');
?>

<div class="blogcontent base_markdown">

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
		<?php
		    $pd = new ParsedownCustom();
		    echo $pd->text(Blog::getPostFragment($post));
        ?>
	</div>

</div>