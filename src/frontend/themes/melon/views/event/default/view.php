<!DOCTYPE html>
<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \event\controllers\DefaultController $this
 * @var \event\models\Event $model
 */
cs()->registerPackage('frontend2.main');
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

<body style="background: url(<?= \fileProcessor\helpers\FPM::originalSrc($model->image_id); ?>) no-repeat center center fixed;">
<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
			<div class="masthead clearfix">
				<div class="inner">
					<h3 class="masthead-brand"><?= $model->label; ?></h3>
				</div>
			</div>

			<div class="inner cover">
				<h1 class="cover-heading"><?= $model->place; ?></h1>
				<h1 class="cover-heading"><?= $model->getBeginDate(); ?></h1>

				<p class="lead"><?= $model->content; ?></p>

				<p class="lead">
					<?= CHtml::link('buy tickets', $model->getBuyPageUrl(), array('class' => 'btn btn-lg btn-info')); ?>
				</p>
			</div>

			<div class="mastfoot">
				<div class="inner">
					<!-- Validation -->
					<p>© 2014 Metalguardian Event</p>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
