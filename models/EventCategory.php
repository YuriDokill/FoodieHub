<?php

namespace app\models;

use yii\db\ActiveRecord;

class EventCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'event_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название категории',
        ];
    }
}