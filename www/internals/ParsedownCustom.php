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

		if (isset($Block['element']['text']['attributes']) && in_array('language-befungerunner', $Block['element']['text']['attributes']))
		{
			$Block['element']['handler'] = 'handleBef93';
			$Block['custom'] = true;
		}
		else if (isset($Block['element']['text']['attributes']) && in_array('language-bfjoustrunner', $Block['element']['text']['attributes']))
		{
			$Block['element']['handler'] = 'handleBFJoust';
			$Block['custom'] = true;
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
		global $PARAM_CODE;
		global $PARAM_URL;
		global $PARAM_INTERACTIVE;

		$PARAM_CODE = $Element['text'];
		$PARAM_URL = '';
		$PARAM_INTERACTIVE = true;

		return require (__DIR__ . '/../fragments/befunge93_runner.php');
	}
}