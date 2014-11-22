<?php
/**
 *
 */

namespace event\controllers;

use event\models\Event;
use front\components\FrontController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionView($id)
	{
		$this->layout = false;
		$model = $this->loadModel($id);

		$this->render('view', array('model' => $model));
	}

	public function getModelClass()
	{
		return Event::getClassName();
	}
}
