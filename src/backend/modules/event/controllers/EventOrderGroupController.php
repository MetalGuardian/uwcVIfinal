<?php
/**
 *
 */

namespace event\controllers;

use back\components\BackController;

/**
 * Class EventOrderGroupController
 */
class EventOrderGroupController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\event\models\EventOrderGroup';
	}
}
