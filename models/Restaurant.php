<?php

namespace app\models;

use Yii;

class Restaurant extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'restaurant';
    }

    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['description'], 'string'],
            [['rating'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'address', 'phone', 'cuisine_type', 'website'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'cuisine_type' => 'Тип кухни',
            'description' => 'Описание',
            'rating' => 'Рейтинг',
            'website' => 'Сайт',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
        }
        $this->updated_at = time();
        return parent::beforeSave($insert);
    }
}