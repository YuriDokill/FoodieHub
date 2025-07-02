<?php

use yii\db\Migration;

class m250628_000000_add_foreign_keys extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_event_category',
            'event',
            'category_id',
            'event_category',
            'id',
            'SET NULL'
        );
        
        $this->addForeignKey(
            'fk_event_organizer',
            'event',
            'organizer_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_event_category', 'event');
        $this->dropForeignKey('fk_event_organizer', 'event');
    }
}
