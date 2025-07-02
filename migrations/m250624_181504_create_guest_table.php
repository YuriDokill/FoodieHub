<?php

use yii\db\Migration;

class m250624_181504_create_guest_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('guest', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'contact_info' => $this->string(255),
            'status' => $this->string(20)->notNull(),
            'is_waiting' => $this->boolean()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_guest_event',
            'guest',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('guest');
    }
}