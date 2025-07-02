<?php

use yii\db\Migration;

class m250625_000001_create_restaurant_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('restaurant', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'phone' => $this->string(20),
            'cuisine_type' => $this->string(100),
            'description' => $this->text(),
            'rating' => $this->decimal(3, 2),
            'website' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('restaurant');
    }
}