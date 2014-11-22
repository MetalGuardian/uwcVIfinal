<?php
/**
 *
 */

namespace event\controllers;

use back\components\BackController;

/**
 * Class EventController
 */
class EventController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\event\models\Event';
	}
}
