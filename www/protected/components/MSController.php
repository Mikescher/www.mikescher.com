<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MSController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/main',
	 * meaning using a single column layout. See 'protected/views/layouts/main.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var string the currently active Element in the Navbar
	 */
	public $selectedNav = '';
}