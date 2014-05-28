<?php

class SiteController extends Controller
{
	public $selectedNav = '';

	public function actionIndex()
	{
		$data = array();

		$data['program'] = ProgrammeHelper::GetDailyProg();

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

	public function actionAbout()
	{
		$data = array();

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

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

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

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}