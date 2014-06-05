<?php
class MsHtml extends CHtml {

	/**
	 * @param DateTime $date
	 * @param string $caption
	 * @param string $link
	 * @return string
	 */
	public static function collapsedHeader($date, $caption, $link = '')
	{
		if (empty($link)) {
			return
				'<div class="row collHeader">
					<div class="collHeaderSpan-front">' . $date->format('d.m.Y') . '</div>
					<div class="collHeaderSpan">' . $caption . '</div>
					<div class="collHeaderSpan-drop"><i class="icon-tag" ></i></div>
				</div>
				';
		} else {
			return
				'<div class="row collHeader collHeaderLinkParent">
					<div class="collHeaderSpan-front">' . $date->format('d.m.Y') . '</div>
					<div class="collHeaderSpan">' . $caption . '</div>
					<div class="collHeaderSpan-drop"><i class="icon-tag" ></i></div>
					<a class="collHeaderLink" href="' . $link . '">&nbsp;</a>
				</div>
				';
		}

	}
} 