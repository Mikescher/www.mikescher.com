<?php

class Fragments
{
	public function PanelEuler()
	{
		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ ];
		include (__DIR__ . '/../fragments/panel_euler.php');
	}

	public function PanelPrograms()
	{
		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ ];
		include (__DIR__ . '/../fragments/panel_programs.php');
	}

	public function PanelBlog()
	{
		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ ];
		include (__DIR__ . '/../fragments/panel_blog.php');
	}

	public function PanelBooks()
	{
		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ ];
		include (__DIR__ . '/../fragments/panel_books.php');
	}

	public function PanelAdventOfCode()
	{
		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ ];
		include (__DIR__ . '/../fragments/panel_aoc.php');
	}

	public function PanelAdventOfCodeCalendar(int $year, bool $shownav, bool $linkheader, bool $ajax, bool $frame=true, $frameid=null)
	{
		if ($frameid == null) $frameid = 'aoc_frame_' . getRandomToken(16);

		global $FRAGMENT_PARAM;
		$FRAGMENT_PARAM = [ 'year' => $year, 'nav'=>$shownav, 'linkheader'=>$linkheader, 'ajax'=>$ajax, 'frame'=>$frame, 'frameid'=>$frameid ];
		include (__DIR__ . '/../fragments/panel_aoc_calendar.php');
	}
}