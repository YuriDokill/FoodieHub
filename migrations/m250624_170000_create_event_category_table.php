<?php

use yii\db\Migration;

class m250624_170000_create_event_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('event_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('event_category');
    }
}