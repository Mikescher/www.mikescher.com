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
}