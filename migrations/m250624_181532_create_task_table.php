<?php

use yii\db\Migration;

class m250624_181532_create_task_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'deadline' => $this->dateTime(),
            'assigned_to' => $this->integer(),
            'status' => $this->string(20)->notNull(),
        ]);

        $this->addForeignKey(
            'fk_task_event',
            'task',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk_task_assigned',
            'task',
            'assigned_to',
            'user',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropTable('task');
    }
}