<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../extern/Parsedown.php');
?>

<div class="blogcontent bc_markdown">

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
		<?php
        $code_own = file_get_contents(__DIR__ . '/../statics/blog/bfjoust_MultiVAC.bfjoust');
        $code_opp = file_get_contents(__DIR__ . '/../statics/blog/bfjoust_Patashu_lazy.bfjoust');

        $pd = new Parsedown();
        $dat = file_get_contents( __DIR__ . '/../statics/blog/bfjoust.md');
        $dat = str_replace("{{CODE}}", $code_own, $dat);

        echo $pd->text($dat);


        global $PARAM_CODE_LEFT;
        global $PARAM_CODE_RIGHT;

		$PARAM_CODE_LEFT = $code_own;
		$PARAM_CODE_RIGHT = $code_opp;
		include (__DIR__ . '/../fragments/bfjoust_runner.php');
        ?>
	</div>

</div>