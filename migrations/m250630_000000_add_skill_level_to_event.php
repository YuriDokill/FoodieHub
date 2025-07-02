<?php

use yii\db\Migration;

class m250630_000000_add_skill_level_to_event extends Migration
{
    public function safeUp()
    {
        $this->addColumn('event', 'skill_level', $this->string(20));
    }

    public function safeDown()
    {
        $this->dropColumn('event', 'skill_level');
    }
}