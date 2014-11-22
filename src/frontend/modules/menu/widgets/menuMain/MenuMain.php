<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace menu\widgets\menuMain;

use core\components\Menu;
use event\models\Event;

/**
 * Class MenuMain
 * @package menu\widgets\menuMain
 */
class MenuMain extends Menu
{
	public $htmlOptions = array('class' => 'nav navbar-nav');
	public function init()
	{
		$items = array(
			array('label' => 'Index', 'url' => array('/site/index')),
			array('label' => 'Events', 'url' => Event::getListPageUrl()),
		);
		$this->items = $items;
		parent::init();
	}
}
