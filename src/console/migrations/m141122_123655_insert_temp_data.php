<?php

/**
 * Class m141122_123655_insert_temp_data
 */
class m141122_123655_insert_temp_data extends \CDbMigration
{
	/**
	 * commands will be executed in transaction
	 */
	public function safeUp()
	{
		$faker = Faker\Factory::create();
		for ($i = 0; $i < 15; $i++) {
			$event = array(
				'label' => 'Event: ' . $faker->catchPhrase,
				'content' => $faker->text(),
				'place' => $faker->address,
				'begin_date' => date('Y-m-d H:i:s', strtotime('+'.mt_rand(0, 30).' days')),
				'image_id' => \fileProcessor\helpers\FPM::transfer()->saveFileByCopy($faker->image('/tmp', '1366', '768'))
			);

			$this->insert('{{event}}', $event);
			$id = $this->dbConnection->getLastInsertID();

			$this->addTickets($id, $faker);

			$this->addPromoCodes($id, $faker);
		}
	}

	/**
	 * @param $id
	 * @param Faker\Generator $faker
	 */
	public function addTickets($id, $faker)
	{
		$tickets = array();
		for ($i = 0; $i < rand(2, 5); $i++) {
			$tickets[] = array(
				'event_id' => $id,
				'label' => 'Ticket: ' . $faker->word,
				'price' => $faker->numberBetween(1, 500),
			);
		}
		$this->insertMultiple('{{event_ticket_type}}', $tickets);
	}

	/**
	 * @param $id
	 * @param Faker\Generator $faker
	 */
	public function addPromoCodes($id, $faker)
	{
		$promos = array();
		for ($i = 0; $i < rand(0, 4); $i++) {
			$promos[] = array(
				'event_id' => $id,
				'code' => $faker->word,
				'discount' => $faker->numberBetween(10, 100),
			);
		}
		if (count($promos)) {
			$this->insertMultiple('{{event_promo_code}}', $promos);
		}
	}

	/**
	 * commands will be executed in transaction
	 */
	public function safeDown()
	{
		$this->execute('SET FOREIGN_KEY_CHECKS = 0;');
		$this->truncateTable('{{event}}');
		$this->truncateTable('{{event_ticket_type}}');
		$this->truncateTable('{{event_promo_code}}');
		$this->truncateTable('{{event_order}}');
		$this->truncateTable('{{event_order_group}}');
		$this->execute('SET FOREIGN_KEY_CHECKS = 1;');
	}
}
