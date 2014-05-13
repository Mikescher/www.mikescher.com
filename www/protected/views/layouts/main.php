<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<?php Yii::app()->bootstrap->register(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<!--if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<!endif]-->

<?php
	$this->widget('bootstrap.widgets.TbNavbar',
		[
			'brandLabel' => Yii::app()->name,
			'display' => null, // default is static to top
			'items' =>
				[
					[
						'class' => 'bootstrap.widgets.TbNav',
						'items' =>
							[
								array('label' => 'Home', 		'url' => '/', 'active' => true),
								array('label' => 'Blog', 		'url' => '#', 'active' => false),
								array('label' => 'Programme', 	'url' => '#', 'active' => false),
								array('label' => 'About',		'url' => '#', 'active' => false),


							],
					],

					TbHtml::navbarSearchForm('search', '',
						[
							'class' => 'pull-right',

							'placeholder' => 'Search',

							'inputOptions' =>
								[
									'append' => TbHtml::submitButton(TbHtml::icon(TbHtml::ICON_SEARCH)),
									'addOnOptions' =>
										[
											'class' => 'pull-right',
										],
									'span' => 2,
								]
						]),
				],
		]);
?>

<?php
	if(isset($this->breadcrumbs))
	{
		$this->widget('bootstrap.widgets.TbBreadcrumb', array(
			'links'=>$this->breadcrumbs,
		));
	}
?>

<?php
	echo $content;
?>

<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
	All Rights Reserved.<br/>
	<?php echo Yii::powered(); ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
<script src="<?php echo (YII_DEBUG ? 'bootstrap.js' : 'bootstrap.min.js') ?>"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>
</html>