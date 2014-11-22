<?php
/**
 *
 */

namespace event\models;

use emailQueue\models\EmailQueue;
use front\components\ActiveRecord;

/**
 * This is the model class for table "{{event_order}}".
 *
 * The followings are the available columns in table '{{event_order}}':
 * @property integer $id
 * @property integer $event_id
 * @property double $real_price
 * @property string $name
 * @property string $email
 * @property integer $promo_code_id
 * @property integer $ticket_id
 * @property string $order_date
 * @property integer $group_id
 *
 * The followings are the available model relations:
 * @property EventTicketType $ticket
 * @property Event $event
 * @property EventOrderGroup $group
 * @property EventPromoCode $promoCode
 */
class EventOrder extends ActiveRecord
{
	public $card_name;
	public $card_code;
	public $promo_code;
	public $discount = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventOrder the static model class
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
		return '{{event_order}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ticket' => array(self::BELONGS_TO, EventTicketType::getClassName(), 'ticket_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'group' => array(self::BELONGS_TO, 'EventOrderGroup', 'group_id'),
			'promoCode' => array(self::BELONGS_TO, 'EventPromoCode', 'promo_code_id'),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, ticket_id, order_date, real_price, name, email', 'required'),
			array('event_id, promo_code_id, ticket_id, group_id', 'numerical', 'integerOnly' => true),
			array('real_price', 'numerical'),
			array('name', 'length', 'max'=>200),
			array('email', 'length', 'max'=>100),
			array('email', 'email'),
			array('card_name, card_code, promo_code', 'safe'),


			array('card_name, card_code', 'required', 'on' => 'checkout'),
			array('card_code', 'match', 'pattern' => '/^[0-9]{16}$/', 'on' => 'checkout'),
			array('card_code', 'validateCard', 'on' => 'checkout'),
		);
	}

	public function validateCard()
	{
		if (!$this->hasErrors()) {
			$revCode = strrev($this->card_code);
			$checksum = 0;

			for ($i = 0; $i < strlen($revCode); $i++) {
				$currentNum = intval($revCode[$i]);
				if($i & 1) {
					$currentNum *= 2;
				}
				$checksum += $currentNum % 10;
				if ($currentNum >  9) {
					$checksum += 1;
				}
			}

			if ($checksum % 10 == 0) {
				return true;
			} else {
				$this->addError('card_code', 'Wrong card number!');
				return false;
			}
		}
		return true;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'id' => 'ID',
				'event_id' => 'Event',
				'real_price' => 'Real Price',
				'name' => 'Name',
				'email' => 'Email',
				'promo_code_id' => 'Promo Code',
				'ticket_id' => 'Ticket',
				'order_date' => 'Order Date',
				'group_id' => 'Group',
			)
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

	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			$this->order_date = date('Y-m-d H:i:s');

			return true;
		}

		return false;
	}

	protected function afterValidate()
	{
		parent::afterValidate();

		if (!$this->hasErrors()) {
			$promo = EventPromoCode::model()
				->compare('t.event_id', $this->event_id)
				->compare('t.code', $this->promo_code)
				->find();
			if ($promo) {
				$this->promo_code_id = $promo->id;
				$this->discount = $this->ticket->price * $promo->discount / 100;
			}

			$this->real_price = $this->ticket->price - $this->discount;
		}
	}

	protected function afterSave()
	{
		parent::afterSave();

		EmailQueue::add('Tickets for event', $this->email, array('model' => $this), 'sendTicket');
	}

	public function getTicketUrl($params = array())
	{
		return self::createUrl(array('/event/default/ticket', 'hash' => md5($this->id . '-' . $this->email)));
	}
}
