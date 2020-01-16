<?php

class Fragments
{
	private function evalFragment($name, $url, $params)
	{
		try
		{
			ob_start();
			{
				global $FRAGMENT_PARAM;
				$FRAGMENT_PARAM = $params;
				/** @noinspection PhpIncludeInspection */
				include (__DIR__ . '/../fragments/' . $url);
			}
			return ob_get_contents();
		}
		finally
		{
			ob_end_clean();
		}
	}

	public function PanelEuler()
	{
		return $this->evalFragment('PanelEuler', 'panel_euler.php', [ ]);
	}

	public function PanelPrograms()
	{
		return $this->evalFragment('PanelPrograms', 'panel_programs.php', [ ]);
	}

	public function PanelBlog()
	{
		return $this->evalFragment('PanelBlog', 'panel_blog.php', [ ]);
	}

	public function PanelBooks()
	{
		return $this->evalFragment('PanelBooks', 'panel_books.php', [ ]);
	}

	public function PanelAdventOfCode()
	{
		return $this->evalFragment('PanelAdventOfCode', 'panel_aoc.php', [ ]);
	}

	public function PanelAdventOfCodeCalendar(int $year, bool $shownav, bool $linkheader, bool $ajax, bool $frame=true, $frameid=null)
	{
		return $this->evalFragment('PanelAdventOfCodeCalendar', 'panel_aoc_calendar.php',
		[
			'year'       => $year,
			'nav'        => $shownav,
			'linkheader' => $linkheader,
			'ajax'       => $ajax,
			'frame'      => $frame,
			'frameid'    => ($frameid == null) ? ('aoc_frame_' . getRandomToken(16)) : $frameid,
		]);
	}

	public function BlogviewPlain(array $blogpost)
	{
		return $this->evalFragment('BlogviewPlain', 'blogview_plain.php',
		[
			'blogpost' => $blogpost,
		]);
	}

	public function BlogviewMarkdown(array $blogpost)
	{
		return $this->evalFragment('BlogviewMarkdown', 'blogview_markdown.php',
		[
			'blogpost' => $blogpost,
		]);
	}

	public function BlogviewEulerList(array $blogpost)
	{
		return $this->evalFragment('BlogviewEulerList', 'blogview_euler_list.php',
		[
			'blogpost' => $blogpost,
		]);
	}

	public function BlogviewEulerSingle(array $blogpost, string $subview)
	{
		return $this->evalFragment('BlogviewEulerSingle', 'blogview_euler_single.php',
		[
			'blogpost' => $blogpost,
			'subview'  => $subview,
		]);
	}

	public function BlogviewAdventOfCodeList(array $blogpost)
	{
		return $this->evalFragment('BlogviewAdventOfCodeList', 'blogview_aoc_list.php',
		[
			'blogpost' => $blogpost,
		]);
	}

	public function BlogviewAdventOfCodeSingle(array $blogpost, string $subview)
	{
		return $this->evalFragment('BlogviewAdventOfCodeSingle', 'blogview_aoc_single.php',
		[
			'blogpost' => $blogpost,
			'subview'  => $subview,
		]);
	}

	public function WidgetBefunge93(string $code, string $url, bool $interactive, int $speed, bool $editable)
	{
		return $this->evalFragment('WidgetBefunge93', 'widget_befunge93.php',
		[
			'code'        => $code,
			'url'         => $url,
			'interactive' => $interactive,
			'speed'       => $speed,
			'editable'    => $editable,
		]);
	}

	public function WidgetBFJoust(string $codeLeft, string $codeRight)
	{
		return $this->evalFragment('WidgetBFJoust', 'widget_bfjoust.php',
		[
			'code_left'  => $codeLeft,
			'code_right' => $codeRight,
		]);
	}
}