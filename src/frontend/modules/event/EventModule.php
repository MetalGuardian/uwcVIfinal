<?php
/**
 *
 */

namespace event;

use core\components\WebModule;

/**
 * Class EventModule
 */
class EventModule extends WebModule
{
	public $controllerNamespace = '\event\controllers';
	//public $defaultController = 'event';

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}
}
