<?php

class BlogPostController extends MSController
{
	public $menu=array();

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index','view', 'ajaxMarkdownPreview'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','update','admin','delete'),
				'users'=>array('@'),
			),

			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 * @throws CHttpException if Enabled is false
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		if (! $model->Enabled && Yii::app()->user->name != 'admin')
			throw new CHttpException(403, 'This Blogpost is locked');

		if ($model->isSpecialBlogPost())
		{
			$controllerMethod = 'viewBlogpost' . $model->ControllerID;
			if(method_exists($this, $controllerMethod))
				$this->$controllerMethod($model);
			else
				throw new CHttpException(500, 'Unknown ControllerID: ' . $controllerMethod);
		}
		else
		{
			$this->render('view',
				[
					'model' => $model,
				]);
		}


	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout = '//layouts/column2';

		$model=new BlogPost;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['BlogPost']))
		{
			$model->attributes=$_POST['BlogPost'];
			if ($model->save())
			{
				$this->redirect(array('view','id'=>$model->ID));
			}
		}

		$this->render('create',
			[
				'model'=>$model,
			]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout = '//layouts/column2';

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['BlogPost']))
		{
			$model->attributes=$_POST['BlogPost'];
			if ($model->save())
			{
				$this->redirect(['view','id'=>$model->ID]);
			}
		}

		$this->render('update',
			[
				'model'=>$model,
			]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		$this->layout = '//layouts/column2';

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
		{
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "Date DESC";

		if (Yii::app()->user->name != 'admin')
		{
			$criteria->addCondition('Visible = 1');
			$criteria->addCondition('Enabled = 1');
		}

		$all = BlogPost::model()->findAll($criteria);

		$this->render('index',
			[
				'blogposts' => $all,
			]
		);
	}

	public function actionAjaxMarkdownPreview()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$this->renderPartial('_ajaxMarkdownPreview',
				[
					'Content' => $_POST['Content'],
				],
				false, true);
		}
		else
		{
			throw new CHttpException(400,'Invalid request. This is a Ajax only action.');
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/column2';

		$model=new BlogPost('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['BlogPost']))
		{
			$model->attributes=$_GET['BlogPost'];
		}

		$this->render('admin',
			[
				'model'=>$model,
			]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BlogPost the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BlogPost::model()->findByPk($id);
		if ($model===null)
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlogPost $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='blog-post-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	//#########################################################################
	//##################### Special Blogpost Controllers ######################
	//#########################################################################

	/**
	 * @param BlogPost $model
	 */
	protected function viewBlogpostProjectEulerBefunge($model)
	{
		$problems = EulerProblem::model()->findAll(['order'=>'Problemnumber']);

		$problemnumber = 0;
		if (isset($_GET['problem']) AND is_numeric($_GET['problem']))
			$problemnumber = $_GET['problem'];

		$criteria=new CDbCriteria;
		$criteria->condition='Problemnumber = ' . $problemnumber;
		$currproblem = EulerProblem::model()->find($criteria);

		if (is_null($currproblem))
		{
			$problemID = -1;
			$currproblem = null;
		}
		else
		{
			$problemID = -1;
			for($i = 0; $i < count($problems); $i++)
				if ($problems[$i]->Problemnumber == $problemnumber)
				{
					$problemID = $i;
					break;
				}
		}

		if ($problemID == -1)
		{
			$problemID = -1;
			$currproblem = null;
		}

		$this->render('view_ProjectEulerBefunge',
			[
				'model' => $model,
				'problems' => $problems,
				'currproblem' => $currproblem,
				'currproblemID' => $problemID,
			]);
	}

	/**
	 * @param BlogPost $model
	 */
	protected function viewBlogpostBFJoustBot($model)
	{

		$this->render('view_BFJoustBot',
			[
				'model' => $model,
			]);
	}

	//#########################################################################
	//#########################################################################
}