<?php
/**
 *
 */

namespace event\controllers;

use event\models\Event;
use event\models\EventOrder;
use front\components\FrontController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontController
{
	public function actionIndex()
	{
		$dataProvider = new \CActiveDataProvider(
			Event::model()
			->compare('t.begin_date', '>=' . date('Y-m-d H:i:s')),
			array(
				'pagination' => array(
					'pageSize' => 10,
				),
				'sort' => array(
					'defaultOrder' => 't.begin_date ASC',
				)
			)
		);

		$this->render('index', array('dataProvider' => $dataProvider));
	}

	public function actionView($id)
	{
		$this->layout = false;
		$model = $this->loadModel($id);

		$this->render('view', array('model' => $model));
	}

	public function actionBuy($id)
	{
		$model = $this->loadModel($id);

		$buy = new EventOrder();

		$step = 1;
		if ($buy->loadData()) {
			$buy->event_id = $model->id;
			if ($buy->validate()) {
				$step = 2;
				$buy->setScenario('checkout');
				if ($buy->validate()) {
					if ($buy->save()) {
						$this->redirect(array('/site/success'));
					}
				}
			}
		}

		$this->render('buy', array('model' => $model, 'buy' => $buy, 'step' => $step));
	}

	public function getModelClass()
	{
		return Event::getClassName();
	}

	public function actionTicket($hash)
	{
		\Yii::import('zii.widgets.CDetailView');
		$this->layout = false;
		$criteria = new \CDbCriteria();
		$criteria->addCondition('MD5(CONCAT(t.id, "-", t.email)) = :hash');
		$criteria->params = array(':hash' => $hash);
		$model = EventOrder::model()->find($criteria);

		if (!$model) {
			throw new \CHttpException(404, 'Ticket not found');
		}

		$html = $this->render('ticket', array('model' => $model), true);
		//$mpdf = new \mPDF();
		//$mpdf->WriteHTML($html);
		//$mpdf->Output();
		// тут баг у mPDF, поэтому так вывожу, без pdf
		echo $html;
		exit;
	}
}
