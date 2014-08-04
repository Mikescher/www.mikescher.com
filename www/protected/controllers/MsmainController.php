<?php

class MSMainController extends MSController
{
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
				'actions'=>array('index', 'about', 'debugerror', 'error', 'login', 'logout', 'search'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "date DESC";

		$all_log = Log::model()->findAll($criteria);
		/* @var $all_log Log[] */

		$data = array();
		$data['program'] = ProgramHelper::GetDailyProg();
		$data['logs'] = $all_log;

		$this->render('index', $data);
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

	public function actionDebugError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('debugerror', $error);
		}
	}

	public function actionAbout()
	{
		$data = array();

		$this->js_scripts[] = file_get_contents('protected/components/extendedgitgraph/script.js');

		if(isset($_POST['SendMailForm']))
		{
			$model = new SendMailForm();

			$model->attributes=$_POST['SendMailForm'];

			if($model->validate()) {
				if ($model->send())
				{
					$data['alerts_success'][] = "Successfully send mail from " . $model->name;
					$data['model'] = new SendMailForm();
				}
				else
				{
					$data['alerts_error'][] = "Internal error while sending mail";
					$data['model'] = $model;
				}

			}
			else
			{
				$data['model'] = $model;
			}
		}
		else
		{
			$data['model'] = new SendMailForm();
		}

		$this->render('about', $data);
	}

	public function actionLogin()
	{
		$model = new LoginForm();

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo TbActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login', array('model'=>$model));
	}

	public function actionAdmin()
	{
		if (isset($_GET['do_egh_update']) && $_GET['do_egh_update'] == '1') {
			$this->layout = null;
			$this->render('admin_updateEGH', array());
			return;
		}

		$this->render('admin', array());
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSearch($search)
	{
		$searchsplit = preg_split('[\+| ]', $search, 8, PREG_SPLIT_NO_EMPTY);

		$results = array_merge(
			Program::getSearchResults($searchsplit),
			BlogPost::getSearchResults($searchsplit),
			Log::getSearchResults($searchsplit),
			HighscoreGames::getSearchResults($searchsplit));

		$this->render('searchresults',
		[
			'searchstring' => $search,
			'result' => $results,
		]);
	}
}