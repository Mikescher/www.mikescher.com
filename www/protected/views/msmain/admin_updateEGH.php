<?php

$this->pageTitle = 'Update EGH - ' . Yii::app()->name;

$this->breadcrumbs =
	[
		'Admin',
	];


$v = new ExtendedGitGraph('Mikescher');

$v->setToken(MsHelper::getStringDBVar('egg_auth-token'));
$v->collect();

$v->generateAndSave();

$v->output_flushed('Generated and Finished');

$v->output_flushed('<a href="/admin" class="btn btn-primary">back</a>');