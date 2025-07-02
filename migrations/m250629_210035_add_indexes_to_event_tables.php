<?php

use yii\db\Migration;

class m250629_210035_add_indexes_to_event_tables extends Migration
{
    public function safeUp()
    {
        // Добавляем индексы для ускорения поиска
        $this->createIndex('idx_event_organizer', 'event', 'organizer_id');
        $this->createIndex('idx_guest_event', 'guest', 'event_id');
        $this->createIndex('idx_task_event', 'task', 'event_id');
        $this->createIndex('idx_expense_event', 'expense', 'event_id');
        
        // Оптимизация для фильтрации по дате
        $this->createIndex('idx_event_date', 'event', 'event_date');
    }

    public function safeDown()
    {
        $this->dropIndex('idx_event_organizer', 'event');
        $this->dropIndex('idx_guest_event', 'guest');
        $this->dropIndex('idx_task_event', 'task');
        $this->dropIndex('idx_expense_event', 'expense');
        $this->dropIndex('idx_event_date', 'event');
    }
}
