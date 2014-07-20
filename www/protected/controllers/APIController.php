<?php

class APIController extends MSController
{
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

	public function actionUpdate()
	{
		if (! isset($_GET['Name'])) {
			throw new CHttpException(404,'Invalid Request - [Name] missing');
			return;
		}

		$Name = $_GET['Name'];

		$this->actionUpdate2($Name);
	}

	public function actionUpdate2($Name)
	{
		$data = ProgramUpdates::model()->findByAttributes(['Name' => $Name]);

		if (! isset($_GET['Name'])) {
			throw new CHttpException(404,'Invalid Request - [Name] not found');
			return;
		}

		$this->render('update', ['data' => $data]);
	}

	public function actionTest()
	{
		$this->render('test', []);
	}
}