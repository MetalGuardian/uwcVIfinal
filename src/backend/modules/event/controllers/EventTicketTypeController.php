<?php
/**
 *
 */

namespace event\controllers;

use back\components\BackController;

/**
 * Class EventTicketTypeController
 */
class EventTicketTypeController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\event\models\EventTicketType';
	}
}
