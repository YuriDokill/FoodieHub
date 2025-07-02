<?php

namespace app\models;

use Yii;

class Recipe extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'recipe';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'description', 'ingredients', 'instructions'], 'required'],
            [['user_id', 'cooking_time', 'created_at', 'updated_at'], 'integer'],
            [['description', 'ingredients', 'instructions'], 'string'],
            [['title', 'difficulty'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Автор',
            'title' => 'Название',
            'description' => 'Описание',
            'ingredients' => 'Ингредиенты',
            'instructions' => 'Инструкции',
            'cooking_time' => 'Время приготовления (мин)',
            'difficulty' => 'Сложность',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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