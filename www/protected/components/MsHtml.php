<?php
class MsHtml extends CHtml {
	public static function collapsedHeader($date, $caption)
	{
		return
		'<div class="well row collHeader">
			<div class="collHeaderSpan-front">' . $date->format('d.m.y') . '</div>
			<div class="collHeaderSpan">' . $caption . '</div>
			<div class="collHeaderSpan-drop"> <i class="icon-chevron-down" ></i> </div>
		</div>
		';
	}
} 