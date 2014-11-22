<?php
/**
 *
 */

namespace event\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $id
 * @property string $label
 * @property string $content
 * @property string $place
 * @property string $begin_date
 * @property integer $image_id
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FpmFile $image
 */
class Event extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
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
		return '{{event}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'image' => array(self::BELONGS_TO, 'FpmFile', 'image_id'),
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
		return self::createUrl(array('/event/default/view', 'id' => $this->id), $params);
	}

	public function getBuyPageUrl($params = array())
	{
		return self::createUrl(array('/event/default/buy', 'id' => $this->id), $params);
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
		return self::createUrl(array('/event/default/index'), $params);
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
				'seo' => array(
					'class' => '\seo\components\SeoModelBehavior',
				),
			)
		);
	}

	public function getTime()
	{
		return date('H:m', strtotime($this->begin_date));
	}

	public function getDate()
	{
		return date('d', strtotime($this->begin_date));
	}

	public function getMonth()
	{
		$format = app()->dateFormatter;
		return $format->format('MMM', $this->begin_date);
	}

	public function getYear()
	{
		return date('Y', strtotime($this->begin_date));
	}

	public function getBeginDate()
	{
		$format = app()->dateFormatter;
		return $format->format('d MMMM y H:m', $this->begin_date);
	}

	public function getStartPrice()
	{
		/** @var EventTicketType $model */
		$model = EventTicketType::model()->compare('t.event_id', $this->id)->order('t.price ASC')->find();

		return $model ? $model->price : 0;
	}

	public function getTickets()
	{
		$models = EventTicketType::model()->compare('t.event_id', $this->id)->visible()->published()->ordered()->findAll();

		$listData = array();
		foreach ($models as $model) {
			$value = $model->id;
			$text = $model->label . ' (Proce: $' . $model->price . ')';
			$listData[$value] = $text;
		}

		return $listData;
	}
}
