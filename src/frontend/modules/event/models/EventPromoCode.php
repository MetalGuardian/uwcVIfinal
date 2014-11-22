<?php
/**
 *
 */

namespace event\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{event_promo_code}}".
 *
 * The followings are the available columns in table '{{event_promo_code}}':
 * @property integer $id
 * @property integer $event_id
 * @property string $code
 * @property double $discount
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property EventOrder[] $eventOrders
 * @property Event $event
 */
class EventPromoCode extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventPromoCode the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event_promo_code}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'eventOrders' => array(self::HAS_MANY, 'EventOrder', 'promo_code_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
		);
	}

	/**
	 * Generate page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	/**
	 * Generate list page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public static function getListPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	/**
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		return \CMap::mergeArray(
			parent::behaviors(),
			array(
			)
		);
	}
}
