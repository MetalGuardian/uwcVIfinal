<?php

/**
 * Class m141122_120230_create_event_promo_code
 */
class m141122_120230_create_event_promo_code extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{event_promo_code}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'event_id' => 'INT NOT NULL COMMENT "Событие"',

				'code' => 'VARCHAR(20) NULL DEFAULT NULL COMMENT "Промо код"',
				'discount' => 'FLOAT NOT NULL DEFAULT 0 COMMENT "Скидка (10-100)"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);
		$this->addForeignKey('fk_event_promo_code_2_event', $this->tableName, 'event_id', '{{event}}', 'id', 'CASCADE', 'CASCADE');
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
