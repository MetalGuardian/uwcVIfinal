<?php
/**
 *
 */

namespace event\controllers;

use back\components\BackController;

/**
 * Class EventOrderController
 */
class EventOrderController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\event\models\EventOrder';
	}

	public function actionDelete($id)
	{
		$this->redirect(array('index'));
	}

	public function actionUpdate($id)
	{
		$this->redirect(array('index'));
	}

	public function actionCreate()
	{
		$this->redirect(array('index'));
	}
}
