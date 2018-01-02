<?php

require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../extern/Parsedown.php');
require_once (__DIR__ . '/../extern/ParsedownExtra.php');


class ParsedownCustom extends ParsedownExtra
{
	protected function element(array $Element)
	{
		if (isset($Element['custom']) && $Element['custom'] && isset($Element['handler']))
			return $this->{$Element['handler']}($Element['text']);
		else
			return parent::element($Element);
	}

	protected function blockFencedCode($Line)
	{
		$Block = parent::blockFencedCode($Line);
		if ($Block === null) return $Block;

		$Block['custom'] = false;

		if (isset($Block['element']['text']['attributes']))
		{
			foreach ($Block['element']['text']['attributes'] as $attr)
			{
				$spl = explode('__', $attr);

				if ($spl[0] === 'language-befungerunner')
				{
					$Block['element']['handler'] = 'handleBef93';
					$Block['custom'] = true;
					$Block['element']['text']['b93_speed'] = null;
					$Block['element']['text']['b93_interactive'] = true;
					$Block['element']['text']['b93_editable'] = true;

					foreach ($spl as $param)
					{
						if (startsWith($param, 'speed-'))       $Block['element']['text']['b93_speed']       = intval( substr($param, strlen('speed-')));
						if (startsWith($param, 'interactive-')) $Block['element']['text']['b93_interactive'] = boolval(substr($param, strlen('interactive-')));
						if (startsWith($param, 'editable-'))    $Block['element']['text']['b93_editable']    = boolval(substr($param, strlen('editable-')));
					}

					return $Block;
				}
				else if ($spl[0] === 'language-bfjoustrunner')
				{
					$Block['element']['handler'] = 'handleBFJoust';
					$Block['custom'] = true;
					return $Block;
				}
			}
		}

		return $Block;
	}

	protected function blockFencedCodeComplete($Block)
	{
		if (! $Block['custom']) { return parent::blockFencedCodeComplete($Block); }

		$Block['element']['custom'] = true;

		return $Block;
	}

	protected function handleBFJoust(array $Element)
	{
		global $PARAM_CODE_LEFT;
		global $PARAM_CODE_RIGHT;

		$split = preg_split("/\-{16,}/", $Element['text']);

		$PARAM_CODE_LEFT  = trim($split[0]);
		$PARAM_CODE_RIGHT = trim($split[1]);

		return require (__DIR__ . '/../fragments/bfjoust_runner.php');
	}

	protected function handleBef93(array $Element)
	{
		global $PARAM_BEFUNGE93RUNNER;
		$PARAM_BEFUNGE93RUNNER =
		[
			'code'        => $Element['text'],
			'url'         => '',
			'interactive' => $Element['b93_interactive'],
			'speed'       => $Element['b93_speed'],
			'editable'    => $Element['b93_editable'],
		];
		return require (__DIR__ . '/../fragments/befunge93_runner.php');
	}
}