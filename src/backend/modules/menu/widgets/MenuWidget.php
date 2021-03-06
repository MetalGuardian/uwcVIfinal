<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace menu\widgets;

\Yii::import('bootstrap.widgets.TbNavbar');

/**
 * Class MenuWidget
 * @package menu\widgets
 */
class MenuWidget extends \TbNavbar
{
	/**
	 * @var bool
	 */
	public $fixed = false;

	/**
	 * @var bool
	 */
	public $collapse = true;

	public function init()
	{
		$items = array();

		$items[] = array('label' => 'Админпанель', 'url' => array('/site/index'));
		$items[] = array('label' => 'Настройки', 'items' => array(
			array('label' => 'Языки', 'url' => array('/language/language/index'), ),
			array('label' => 'Переводы', 'items' => array(
				array('label' => 'Переводы', 'url' => array('/translate/message/index'), ),
				array('label' => 'Оригиналы', 'url' => array('/translate/sourceMessage/index'), ),
				array('label' => 'Не переведенные фразы', 'url' => array('/translate/messageMissing/index'), ),
			),),
			array('label' => 'Конфигурация', 'url' => array('/configuration/configuration/index'), ),
			array('label' => 'Seo', 'url' => array('/seo/seo/index'), ),
			array('label' => 'Почта', 'url' => array('/emailQueue/emailQueue/index'), ),
		));
		$items[] = array('label' => 'Объекты', 'items' => array(
			array('label' => 'Events', 'url' => array('/event/event/index'), ),
			array('label' => 'Events Tickets', 'url' => array('/event/eventTicketType/index'), ),
			array('label' => 'Events Promo Codes', 'url' => array('/event/eventPromoCode/index'), ),
			array('label' => 'Events Orders', 'url' => array('/event/eventOrder/index'), ),
		),);
		$items[] = array('label' => 'Пользователи', 'items' => array(
			array('label' => 'Админ', 'url' => array('/admin/user/index'), ),
		), );

		$items[] = array('label' => 'Выход' .' (' . user()->name . ')', 'url' => array('/admin/user/logout'));

		$this->items = array(
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'items' => user()->getIsAdmin() ? $items : array(),
			),
		);

		parent::init();

		if (!$this->brand) {
			$this->brand = app()->name;
		}
		if (!$this->brandUrl) {
			$this->brandUrl = app()->homeUrl;
		}
	}
}
