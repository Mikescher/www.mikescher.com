<?php /* @var $this MSController */ ?>

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
	<title><?php
		echo $this->pageTitle; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<link rel="icon" type="image/png" href="/images/favicon.png"/> <?php //TODO-MS Add nice favicon ?>

	<?php Yii::app()->bootstrap->register(); ?>
	<link rel="stylesheet" type="text/css" href="/css/styles.css"/>
	<link rel="stylesheet" type="text/css" href="/css/prism.css"/>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<!--if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<!endif]-->

<div id="fullbodywrapper">

	<?php
	if (!isset($this->selectedNav)) $this->selectedNav = "";

	$this->widget('bootstrap.widgets.TbNavbar',
		[
			'brandLabel' => '<img src="/images/logo_static.png" class="brandLogo"/>',
			'brandUrl' => '/',
			'display' => null,
			'htmlOptions' =>
				[
					'class' => 'cstm-main-navbar'
				],
			'items' =>
				[
					[
						'class' => 'bootstrap.widgets.TbNav',
						'items' =>
							[
								['label' => 'Home', 'url' => '/', 'active' => ($this->selectedNav === 'index')],
								['label' => 'Blog', 'url' => '/blog', 'active' => ($this->selectedNav === 'blog')],
								['label' => 'Programs', 'url' => '/programs', 'active' => ($this->selectedNav === 'prog')],
								['label' => '', 'items' => ProgramHelper::GetProgDropDownList(), 'htmlOptions' => ['class' => 'dropdown-append']],
								['label' => 'About', 'url' => '/about', 'active' => ($this->selectedNav === 'about')],
								['label' => '[[Log "' . Yii::app()->user->name . '" out]]', 'url' => '/logout', 'visible' => !Yii::app()->user->isGuest, 'htmlOptions' => ['class' => 'cstm-main-navbar-highlight']]
							],
					],
					MsHtml::navbarSearchForm('/search', '',
						[
							'class' => 'pull-right',
							'placeholder' => 'Search',
							'inputOptions' =>
								[
									'append' => MsHtml::submitButton(MsHtml::icon(MsHtml::ICON_SEARCH)),
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
	if (isset($this->breadcrumbs)) {
		$this->widget('bootstrap.widgets.TbBreadcrumb',
			[
				'links' => $this->breadcrumbs,
			]);
	}
	?>

	<?php
	echo $content;
	?>

	<div class="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Mike Schwörer &#xb7; <i><a href="/admin">{{admin}}</a></i><br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/javascript/scripts.js"></script>
<script src="/javascript/prism.js"></script>

<?php
foreach ($this->js_scripts as $script) {
	echo '<script type="text/javascript" language="JavaScript">', PHP_EOL;
	echo $script;
	echo '</script>', PHP_EOL;
}
?>

</body>
</html>