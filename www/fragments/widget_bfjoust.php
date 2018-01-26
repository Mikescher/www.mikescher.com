<?php
require_once (__DIR__ . '/../internals/base.php');

global $PARAM_CODE_LEFT;
global $PARAM_CODE_RIGHT;

$result = '';

$result .= '<div class="bfjoust_runner_owner">' . "\n";
$result .= '	<div class="hsplit">' . "\n";
$result .= '		<textarea class="hsplit_1 source" id="source_1">' . htmlspecialchars($PARAM_CODE_LEFT)  . '</textarea>' . "\n";
$result .= '		<textarea class="hsplit_2 source" id="source_2">' . htmlspecialchars($PARAM_CODE_RIGHT) . '</textarea>' . "\n";
$result .= '	</div>' . "\n";

$result .= '	<div id="commandpanel">' . "\n";
$result .= '		<div>' . "\n";
$result .= '			<div>' . "\n";
$result .= '				<a href="#" id="a_expand">expand</a>|<a href="#" id="a_collapse">collapse</a>|<a href="#" id="a_run">run</a>' . "\n";
$result .= '				(size:<input type="number" id="run_size" min="10" max="30" value="30" width="30"> speed:<input type="number" id="run_speed" min="0" max="10000" value="10">)' . "\n";
$result .= '				| <a href="#" id="a_stop">stop</a> | <a href="#" id="a_arena">arena</a>' . "\n";
$result .= '			</div>' . "\n";
$result .= '		</div>' . "\n";
$result .= '	</div>' . "\n";

$result .= '	<div class="hsplit">' . "\n";
$result .= '		<textarea class="hsplit_1 sink" id="sink_1"></textarea>' . "\n";
$result .= '		<textarea class="hsplit_2 sink" id="sink_2"></textarea>' . "\n";
$result .= '	</div>' . "\n";

$result .= '	<div class="hsplit">' . "\n";
$result .= '		<canvas   class="hsplit_1 bottomelem" id="board"></canvas>' . "\n";
$result .= '		<textarea class="hsplit_2 bottomelem" id="log" wrap="off"> </textarea>' . "\n";
$result .= '	</div>' . "\n";
$result .= '</div>' . "\n";

$result .= '' . "\n";

$result .= includeScriptOnce("/data/javascript/blogpost_BFJoustBot_script.js", false, '') . "\n";

return $result;