<?php
/**
 * Author: metal
 * Email: metal
 */

namespace event\widgets\latestEvent;

use event\models\Event;
use front\components\Widget;

/**
 * Class LatestEvent
 * @package event\widgets\latestEvent
 */
class LatestEvent extends Widget
{
	public $count = 3;
	public function run()
	{
		$models = Event::model()->order('t.begin_date ASC')->compare('t.begin_date', '>=' . date('Y-m-d H:i:s'))->limit($this->count)->findAll();
		if (!count($models)) {
			return null;
		}
		$this->render('default', array('models' => $models));
	}
} 
