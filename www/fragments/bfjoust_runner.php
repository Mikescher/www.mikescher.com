<?php
require_once (__DIR__ . '/../internals/base.php');

global $PARAM_CODE_LEFT;
global $PARAM_CODE_RIGHT;

?>

<div class="bfjoust_runner_owner" >
	<div class="hsplit">
		<textarea class="hsplit_1 source" id="source_1"><?php echo htmlspecialchars($PARAM_CODE_LEFT); ?></textarea>
		<textarea class="hsplit_2 source" id="source_2"><?php echo htmlspecialchars($PARAM_CODE_RIGHT); ?></textarea>
	</div>

	<div id="commandpanel">
		<div>
			<div>
				<a href="#" id="a_expand">expand</a>
				|
				<a href="#" id="a_collapse">collapse</a>
				|
				<a href="#" id="a_run">run</a>
				(size:
				<input type="number" id="run_size" min="10" max="30" value="30" width="30">
				speed:
				<input type="number" id="run_speed" min="0" max="10000" value="10">
				)
				|
				<a href="#" id="a_stop">stop</a>
				|
				<a href="#" id="a_arena">arena</a>
			</div>
		</div>
	</div>

	<div class="hsplit">
		<textarea class="hsplit_1 sink" id="sink_1"></textarea>
		<textarea class="hsplit_2 sink" id="sink_2"></textarea>
	</div>

	<div class="hsplit">
		<canvas   class="hsplit_1 bottomelem" id="board"></canvas>
		<textarea class="hsplit_2 bottomelem" id="log" wrap="off"> </textarea>
	</div>
</div>

<script src="/data/javascript/blogpost_BFJoustBot_script.js"></script>
