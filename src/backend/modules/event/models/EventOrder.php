<?php
/**
 *
 */

namespace event\models;

use back\components\ActiveRecord;

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
			'ticket' => array(self::BELONGS_TO, 'EventTicketType', 'ticket_id'),
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
			array('event_id, ticket_id, order_date', 'required'),
			array('event_id, promo_code_id, ticket_id, group_id', 'numerical', 'integerOnly' => true),
			array('real_price', 'numerical'),
			array('name', 'length', 'max' => 200),
			array('email', 'length', 'max' => 100),
			// The following rule is used by search().
			array('id, event_id, real_price, name, email, promo_code_id, ticket_id, order_date, group_id', 'safe', 'on' => 'search', ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'event_id' => 'Событие',
				'real_price' => 'Реальная Цена',
				'name' => 'Имя',
				'email' => 'Email',
				'promo_code_id' => 'Промо код',
				'ticket_id' => 'Билет',
				'order_date' => 'Время заказа',
				'group_id' => 'Группа',
			)
		);
		$labels = $this->generateLocalizedAttributeLabels($labels);
		return $labels;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @param bool $pageSize
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($pageSize = false)
	{
		$criteria = new \CDbCriteria();

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.event_id', $this->event_id);
		$criteria->compare('t.real_price', $this->real_price);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.email', $this->email, true);
		$criteria->compare('t.promo_code_id', $this->promo_code_id);
		$criteria->compare('t.ticket_id', $this->ticket_id);
		$criteria->compare('t.order_date', $this->order_date, true);
		$criteria->compare('t.group_id', $this->group_id);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'id' => \CSort::SORT_DESC,
				),
			),
		));
	}

	/**
	 * Generate breadcrumbs
	 *
	 * @param string $page
	 * @param null|string $title
	 *
	 * @return array
	 */
	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'EventOrder');
	}

	/**
	 * Get columns configs to specified page for grid or detail view
	 *
	 * @param $page
	 *
	 * @return array
	 */
	public function genColumns($page)
	{
		$columns = array();
		switch ($page) {
			case 'index':
				$columns = array(
					array(
						'name' => 'id',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					'event_id',
					'email',
					'promo_code_id',
					'ticket_id',
					'group_id',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'event_id',
					'real_price',
					'name',
					'email',
					'promo_code_id',
					'ticket_id',
					'order_date',
					'group_id',
				);
				break;
			default:
				break;
		}
		return $columns;
	}

	/**
	 * Get form config
	 *
	 * @return array
	 */
	public function getFormConfig()
	{
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'elements' => array(
				'event_id' => array(
					'type' => 'text',
					'class' => 'span3',
				),
				'real_price' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'name' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'email' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'promo_code_id' => array(
					'type' => 'text',
					'class' => 'span3',
				),
				'ticket_id' => array(
					'type' => 'text',
					'class' => 'span3',
				),
				'order_date' => array(
					'type' => '\yiiDateTimePicker\CJuiDateTimePicker',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => 'yy-mm-dd',
						'showSecond' => true,
						'timeFormat' => 'HH:mm:ss',
					),
				),
				'group_id' => array(
					'type' => 'text',
					'class' => 'span3',
				),
			),

			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'layoutType' => 'primary',
					'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Сбросить',
				),
			),
		);
	}

	/**
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		/*
		 * Warning: every behavior need contains fields:
		 * 'configLanguageAttribute' required
		 * 'configBehaviorAttribute' required
		 * 'configBehaviorKey' optional (default: b_originKey_lang, where originKey is key of the row in array
		 * lang will be added in tail
		 */
		$languageBehaviors = array();
		$behaviors = $this->prepareBehaviors($languageBehaviors);
		return \CMap::mergeArray(
			parent::behaviors(),
			\CMap::mergeArray(
				$behaviors,
				array(
				)
			)
		);
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.id DESC');
	}
}
