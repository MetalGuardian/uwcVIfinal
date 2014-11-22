<?php

/**
 * Class m141122_105407_create_event_table
 */
class m141122_105407_create_event_table extends \CDbMigration
{
	/**
	 * migration related table name
	 */
	public $tableName = '{{event}}';

	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$this->createTable(
			$this->tableName,
			array(
				'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',

				'label' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Заголовок"',
				'content' => 'TEXT NULL DEFAULT NULL COMMENT "Описание"',
				'place' => 'VARCHAR(200) NULL DEFAULT NULL COMMENT "Место проведения"',
				'begin_date' => 'DATETIME NULL DEFAULT NULL COMMENT "Время начала проведения"',
				'image_id' => 'INT UNSIGNED NULL DEFAULT NULL COMMENT "Изображение"',

				'visible' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'published' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
				'position' => 'INT UNSIGNED NOT NULL DEFAULT 0',
			),
			'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
		);

		$this->addForeignKey('fk_event_image_id_2_images', $this->tableName, 'image_id', '{{fpm_file}}', 'id', 'SET NULL', 'SET NULL');
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->dropTable($this->tableName);
	}
}
