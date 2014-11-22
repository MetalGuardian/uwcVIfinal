<?php
/**
 *
 */

namespace event\controllers;

use back\components\BackController;

/**
 * Class EventPromoCodeController
 */
class EventPromoCodeController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\event\models\EventPromoCode';
	}
}
