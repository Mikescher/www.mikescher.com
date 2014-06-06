<?php
class MsHtml extends TbHtml {

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

	/**
	 * @param DateTime $date
	 * @param string $caption
	 * @param $parent
	 * @param $target
	 * @return string
	 */
	public static function interactiveCollapsedHeader($date, $caption, $parent, $target)
	{
		return
			'<div class="row collHeader collHeaderLinkParent">
				<div class="collHeaderSpan-front">' . $date->format('d.m.Y') . '</div>
				<div class="collHeaderSpan">' . $caption . '</div>
				<div class="collHeaderSpan-drop"><i class="icon-tag" ></i></div>
				<a class="collHeaderLink" data-toggle="collapse" ' . (empty($parent) ? ('') : ('data-parent="' . $parent . '"')) . ' href="' . $target . '">&nbsp;</a>
			</div>
			';
	}

	/**
	 * Generates a pager header.
	 * @param string $heading the heading text.
	 * @param string $subtext the subtext.
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated pager header.
	 */
	public static function pageHeader($heading, $subtext, $htmlOptions = array())
	{
		self::addCssClass('page-header', $htmlOptions);
		$headerOptions = TbArray::popValue('headerOptions', $htmlOptions, array());
		$subtextOptions = TbArray::popValue('subtextOptions', $htmlOptions, array());
		$output = self::openTag('div', $htmlOptions);
		$output .= self::openTag('h1', $headerOptions);
		$output .= parent::encode($heading) . ' ' . self::tag('small', $subtextOptions, $subtext);
		$output .= '</h1>';
		$output .= '<hr>';
		$output .= '</div>';
		return $output;
	}
} 