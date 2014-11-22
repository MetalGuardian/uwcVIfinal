<?php

/**
 * Class m141122_123650_create_event_order
 */
class m141122_123650_create_event_order extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{event_order}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'event_id' => 'INT NOT NULL COMMENT "Событие"',

				'price' => 'FLOAT NOT NULL DEFAULT 0 COMMENT "Цена"',
				'real_price' => 'FLOAT NOT NULL DEFAULT 0 COMMENT "Реальная Цена"',
				'name' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Имя"',
				'email' => 'VARCHAR(100) NULL DEFAULT NULL COMMENT "Email"',

				'promo_code_id' => 'INT NULL DEFAULT NULL COMMENT "Промо код"',

				'order_date' => 'DATETIME NOT NULL COMMENT "Время заказа"',

				'group_id' => 'INT NOT NULL COMMENT "Группа"',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
		$this->addForeignKey('fk_event_order_event_2_event', $this->tableName, 'event_id', '{{event}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_event_order_group_2_group', $this->tableName, 'group_id', '{{event_order_group}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_event_order_promo_2_promo', $this->tableName, 'promo_code_id', '{{event_promo_code}}', 'id', 'CASCADE', 'CASCADE');
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
