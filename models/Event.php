<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Event extends ActiveRecord
{
    const SKILL_BEGINNER = 'beginner';
    const SKILL_INTERMEDIATE = 'intermediate';
    const SKILL_ADVANCED = 'advanced';

    public static function tableName()
    {
        return 'event';
    }

    public function rules()
    {
        return [
            [['title', 'description', 'event_date', 'location', 'organizer_id'], 'required'],
            [['description'], 'string'],
            [['event_date'], 'safe'],
            [['expected_guests', 'category_id', 'organizer_id'], 'integer'],
            [['title', 'location', 'format', 'cuisine_type', 'skill_level'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['skill_level'], 'in', 'range' => [self::SKILL_BEGINNER, self::SKILL_INTERMEDIATE, self::SKILL_ADVANCED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'description' => Yii::t('app', 'Описание'),
            'event_date' => Yii::t('app', 'Дата и время'),
            'location' => Yii::t('app', 'Место проведения'),
            'format' => Yii::t('app', 'Формат'),
            'cuisine_type' => Yii::t('app', 'Тип кухни'),
            'expected_guests' => Yii::t('app', 'Ожидаемое кол-во гостей'),
            'category_id' => Yii::t('app', 'Категория'),
            'organizer_id' => Yii::t('app', 'Организатор'),
            'skill_level' => Yii::t('app', 'Уровень мастерства'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    public static function getSkillLevels()
    {
        return [
            self::SKILL_BEGINNER => Yii::t('app', 'Новичок'),
            self::SKILL_INTERMEDIATE => Yii::t('app', 'Средний'),
            self::SKILL_ADVANCED => Yii::t('app', 'Профессионал'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(EventCategory::class, ['id' => 'category_id']);
    }

    public function getOrganizer()
    {
        return $this->hasOne(User::class, ['id' => 'organizer_id']);
    }

    // УБИРАЕМ ДУБЛИРУЮЩИЙСЯ МЕТОД getGuests()
    // ВМЕСТО ЭТОГО ОСТАВЛЯЕМ ЕДИНСТВЕННЫЙ МЕТОД:

    public function getGuests()
    {
        return $this->hasMany(Guest::class, ['event_id' => 'id']);
    }

    public function getConfirmedGuestsCount()
    {
        return $this->getGuests()
            ->andWhere(['status' => Guest::STATUS_CONFIRMED])
            ->count();
    }
    
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['event_id' => 'id']);
    }

    public function getExpenses()
    {
        return $this->hasMany(Expense::class, ['event_id' => 'id']);
    }

    public function getTotalExpenses()
    {
        return $this->getExpenses()->sum('amount');
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_string($this->event_date)) {
                $this->event_date = date('Y-m-d H:i:s', strtotime($this->event_date));
            }
            return true;
        }
        return false;
    }
}