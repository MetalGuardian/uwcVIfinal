<?php
/**
 *
 */

namespace event\models;

use back\components\ActiveRecord;

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
			'event' => array(self::BELONGS_TO, Event::getClassName(), 'event_id'),
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
			array('event_id, code', 'required'),
			array('event_id, visible, published, position', 'numerical', 'integerOnly' => true),
			array('discount', 'numerical', 'min' => 10, 'max' => 100),
			array('code', 'length', 'max' => 20),
			// The following rule is used by search().
			array('id, event_id, code, discount, visible, published, position', 'safe', 'on' => 'search', ),
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
				'code' => 'Промо код',
				'discount' => 'Скидка',
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
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.discount', $this->discount);
		$criteria->compare('t.visible', $this->visible);
		$criteria->compare('t.published', $this->published);
		$criteria->compare('t.position', $this->position);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'position' => \CSort::SORT_DESC,
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'EventPromoCode');
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
					array(
						'name' => 'event_id',
						'filter' => \CHtml::listData(Event::getItems(), 'id', 'label'),
						'value' => function (EventPromoCode $data) {
							return $data->getValue('event', 'label');
						},
					),
					'code',
					'discount',
					array(
						'class' => 'back\components\CheckColumn',
						'header' => 'Видим',
						'name' => 'visible',
					),
					array(
						'class' => 'back\components\CheckColumn',
						'header' => 'Опубликовано',
						'name' => 'published',
					),
					array(
						'name' => 'position',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					array(
						'name' => 'event_id',
						'value' => $this->getValue('event', 'label'),
					),
					'code',
					'discount',
					'visible:boolean',
					'published:boolean',
					'position',
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
					'type' => 'dropdownlist',
					'items' => \CHtml::listData(Event::getItems(), 'id', 'label'),
					'class' => 'span3',
					'prompt' => 'select'
				),
				'code' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'discount' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'visible' => array(
					'type' => 'checkbox',
				),
				'published' => array(
					'type' => 'checkbox',
				),
				'position' => array(
					'type' => 'text',
					'class' => 'span2',
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
}
