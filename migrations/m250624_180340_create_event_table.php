<?php

use yii\db\Migration;

class m250624_180340_create_event_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'event_date' => $this->dateTime()->notNull(),
            'location' => $this->string(255)->notNull(),
            'format' => $this->string(255),
            'cuisine_type' => $this->string(255),
            'expected_guests' => $this->integer(),
            'category_id' => $this->integer(),
            'organizer_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('event');
    }
}