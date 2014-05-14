<?php

class SiteController extends Controller
{
	public $selectedNav = '';

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionAbout()
	{
		$this->render('about');
	}
}