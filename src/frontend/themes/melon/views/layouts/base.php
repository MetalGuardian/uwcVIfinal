<!DOCTYPE html>
<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */
/**
 * @var $this \front\components\FrontController
 * @var $content
 */
cs()->registerPackage('frontend.main');
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
<div class="collapse navbar-collapse">
	<?php $this->widget(\menu\widgets\menuMain\MenuMain::getClassName()); ?>
</div>
</nav>
<div class="container">
	<?php echo $content; ?>
</div>
<div class="container">
	<hr>
	<footer>
		<p class="pull-left">Copyright &copy; <?php echo date('Y'); ?></p>
		<p class="pull-right"><?php echo Yii::powered(); ?></p>
		<div class="clearfix"></div>
		<p>Отработало за <?php echo sprintf('%0.5f', \Yii::getLogger()->getExecutionTime()); ?> с. Память: <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB"; ?></p>
	</footer>
</div>
</body>
</html>
