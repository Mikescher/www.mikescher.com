<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MSController extends CController
{
	public $layout = '//layouts/main';

	public $breadcrumbs = array();

	public $selectedNav = '';

	public $js_scripts = array();
	public $js_files = array();
	public $css_files =
	[
		"/css/styles.css",
		"/css/prism.css",
	];

	public $title = null;

	public $searchvalue = '';

	public function beforeAction($e){
		Yii::app()->hitcounter->increment();

		return parent::beforeAction($e);
	}
}