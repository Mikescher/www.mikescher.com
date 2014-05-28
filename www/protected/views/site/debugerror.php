<?php
/* @var $this SiteController */
/* @var $error array */

	$this->pageTitle=Yii::app()->name . ' - Error';
	
	$this->breadcrumbs=array(
		'Error (debug)',
	);

	$content = $message. "\n\n" .
		'File: <code>' . $file. '</code> : <code>' . $line . "</code>\n\n" .
		"Stacktrace:\n" .
		'<div class="well">' . $trace . '</div>' . "\n";


	$this->widget('bootstrap.widgets.TbHeroUnit', array(
		'heading' => 'ERROR ' . $type . ': ' . $code,
		'content' => nl2br($content),
	));
?>
