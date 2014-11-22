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
}
