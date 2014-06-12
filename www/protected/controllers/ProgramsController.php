<?php

class ProgramsController extends MSController
{
	const PROGS_INDEX_ROWSIZE = 4;
	const PROGS_INDEX_PAGESIZE = 16;

	public $layout='//layouts/column2';

	public $menu=array();

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete'),
				'users'=>array('@'),
			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array(),
//					'users'=>array('admin'),
//			),
			array('deny',  // deny everythign else to all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 * @throws CHttpException when $id is integer
	 */
	public function actionView($id)
	{
		$this->layout = '//layouts/main';

		if (is_numeric($id))
		{
			if (Yii::app()->user->name == 'admin') {
				$model = $this->loadModelByID($id);
			} else {
				throw new CHttpException(400, "You can't access a program by ID");
			}
		}
		else
		{
			$model = $this->loadModelByName($id);
		}

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Program();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Program'])) {
			$model->attributes=$_POST['Program'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->ID));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModelByID($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Program'])) {
			$model->attributes=$_POST['Program'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->ID));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 * @throws CHttpException on invalid request
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModelByID($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/main';

		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$criteria = new CDbCriteria;
		$criteria->order = "Sterne DESC, add_date DESC";
		$criteria->condition = "visible=1";

		$all = Program::model()->findAll($criteria);
		/* @var $all Program[] */

		$pagecount = ceil(count($all) / self::PROGS_INDEX_PAGESIZE);

		$all = array_slice($all, ($page - 1) * self::PROGS_INDEX_PAGESIZE, self::PROGS_INDEX_PAGESIZE);

		$rowcount = ceil((count($all) / self::PROGS_INDEX_ROWSIZE));

		$progdata = array();
		for ($i = 0; $i < $rowcount; $i++) {
			$progdata[] = array();
			foreach (array_slice($all, $i * self::PROGS_INDEX_ROWSIZE, self::PROGS_INDEX_ROWSIZE) as $record) {
				$progdata[$i][] = $record;
			}
		}

		//#######

		$data = array();
		$data['page'] = $page;
		$data['pagecount'] = $pagecount;
		$data['rowcount'] = $rowcount;
		$data['data'] = $progdata;

		$this->render('index', $data);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Program('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Program'])) {
			$model->attributes=$_GET['Program'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Program the loaded model
	 * @throws CHttpException
	 */
	public function loadModelByID($id)
	{
		$model=Program::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested Programm (by ID) does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the name of Program
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param string $name the ID of the model to be loaded
	 * @return Program the loaded model
	 * @throws CHttpException
	 */
	public function loadModelByName($name)
	{
		$model=Program::model()->findByAttributes(['Name' => $name]);
		if ($model===null) {
			throw new CHttpException(404,'The requested programm (by Name) does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Program $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='program-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}