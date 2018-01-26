<?php

class HighscoresController extends MSController //TODO-MS Test online if it all works
{
	const ENTRYLIST_PAGESIZE = 20;

	public $layout = false;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('*'),
			),
		);
	}

	public function actionInsert($gameid, $check, $name, $rand, $points)
	{
		if (! is_numeric($gameid))
			throw new CHttpException(400, 'Invalid Request');
		if (! is_numeric($points))
			throw new CHttpException(400, 'Invalid Request');

		$entry = new HighscoreEntries();
		$entry->GAME_ID = $gameid;
		$entry->POINTS = $points;
		$entry->PLAYER = $name;
		$entry->PLAYERID = -1;
		$entry->CHECKSUM = $check;
		$entry->TIMESTAMP = date("Y-m-d H:m:s", time());
		$entry->IP = $_SERVER['REMOTE_ADDR'];

		if ($entry->checkChecksum($rand))
		{
			if ($entry->save())
			{
				$this->actionListEntries($gameid);
				return;
			}
			else
			{
				echo 'Error while inserting';
				return;
			}
		}
		else
		{
			echo 'Nice try !';
			return;
		}
	}

	public function actionList()
	{
		if (!isset($_GET["gameid"]))
		{
			$this->actionListGames();
			return;
		}
		else
		{
			$this->actionListEntries(intval(htmlspecialchars($_GET["gameid"])));
			return;
		}
	}

	public function actionListEntries($gameid)
	{
		if (! is_numeric($gameid))
			throw new CHttpException(400, 'Invalid Request - [gameid] must be an integer');

		if (!isset($_GET["start"]))
		{
			$start = 0;
		}
		else
		{
			$start = intval(htmlspecialchars($_GET["start"])) - 1;
			if ($start < 0)
			{
				$start = 0;
			}
		}

		if (isset($_GET["highlight"]))
		{
			$highlight= intval(htmlspecialchars($_GET["highlight"]));
		}
		else
			$highlight = 0;

		$game = HighscoreGames::model()->findByPk($gameid);

		$this->render('listentries',
			[
				'game' => $game,
				'start' => $start,
				'highlight' => $highlight,
				'pagesize' => self::ENTRYLIST_PAGESIZE,
			]);
	}

	public function actionListGames()
	{
		$criteria = new CDbCriteria;
		$games = HighscoreGames::model()->findAll($criteria);

		$this->render('listgames',
			[
				'games' => $games,
			]);
	}

	public function actionUpdate($gameid, $check, $name, $nameid, $rand, $points)
	{
		if (! is_numeric($gameid))
			throw new CHttpException(400, 'Invalid Request');
		if (! is_numeric($nameid))
			throw new CHttpException(400, 'Invalid Request');
		if (! is_numeric($points))
			throw new CHttpException(400, 'Invalid Request');

		$criteria = new CDbCriteria;
		$criteria->addCondition('GAME_ID = ' . $gameid);
		$criteria->addCondition('PLAYERID = ' . $nameid);

		/* @var HighscoreEntries $entry  */
		$entry = HighscoreEntries::model()->find($criteria);

		if (is_null($entry))
		{
			$entry = new HighscoreEntries();
			$entry->GAME_ID = $gameid;
			$entry->POINTS = $points;
			$entry->PLAYER = $name;
			$entry->PLAYERID = -1;
			$entry->CHECKSUM = $check;
			$entry->TIMESTAMP = date("Y-m-d H:m:s", time());
			$entry->IP = $_SERVER['REMOTE_ADDR'];

			if ($entry->checkChecksum($rand))
			{
				if ($entry->save())
				{
					$this->actionListEntries($gameid);
					return;
				}
				else
				{
					echo 'Error while inserting';
					return;
				}
			}
			else
			{
				echo 'Nice try !';
				return;
			}
		}
		else
		{
			$entry->POINTS = $points;
			$entry->PLAYER = $name;
			$entry->CHECKSUM = $check;
			$entry->IP = $_SERVER['REMOTE_ADDR'];

			if ($entry->checkChecksum($rand))
			{
				$entry->update();
				$this->actionListEntries($gameid);
			}
			else
			{
				echo 'Nice try !';
				return;
			}
		}

	}

	public function actionList_Top50($gameid)
	{
		if (! is_numeric($gameid))
			throw new CHttpException(400, 'Invalid Request - [gameid] must be an integer');

		$game = HighscoreGames::model()->findByPk($gameid);

		$this->render('list_top50',
			[
				'game' => $game,
			]);
	}

	public function actionNewID($gameid)
	{
		$connection=Yii::app()->db;
		$command=$connection->createCommand("SELECT MAX(PLAYERID)+1 AS NID FROM {{highscoreentries}} WHERE GAME_ID = $gameid");

		$newid = $command->queryScalar();
		if ($newid < 1024) {
			$newid = 1024;
		}

		print $newid;
	}
}