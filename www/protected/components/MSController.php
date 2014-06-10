<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MSController extends CController
{
	public $layout='//layouts/main';

	public $breadcrumbs=array();

	public $selectedNav = '';

	public $js_scripts = array();

	public $title = null;
}