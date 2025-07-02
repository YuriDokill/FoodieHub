<?php

use yii\db\Migration;

class m250624_181614_create_expense_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('expense', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'description' => $this->string(255)->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'category' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk_expense_event',
            'expense',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('expense');
    }
}