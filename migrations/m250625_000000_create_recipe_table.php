<?php

use yii\db\Migration;

class m250625_000000_create_recipe_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('recipe', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'ingredients' => $this->text()->notNull(),
            'instructions' => $this->text()->notNull(),
            'cooking_time' => $this->integer(),
            'difficulty' => $this->string(50),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_recipe_user',
            'recipe',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('recipe');
    }
}