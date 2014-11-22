<?php

/**
 * Class m141122_123643_create_event_order_group
 */
class m141122_123643_create_event_order_group extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{event_order_group}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
