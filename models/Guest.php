<?php

namespace app\models;

use Yii;
use app\models\Event;

/**
 * This is the model class for table "guest".
 *
 * @property int $id
 */
class Guest extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_DECLINED = 'declined';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'name', 'status'], 'required'],
            [['event_id'], 'integer'],
            [['name', 'contact_info'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['is_waiting'], 'boolean'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Мероприятие',
            'name' => 'Имя',
            'contact_info' => 'Контактная информация',
            'status' => 'Статус',
            'is_waiting' => 'В списке ожидания',
        ];
    }

    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $event = $this->event;
        if (!$event) return;
        
        $confirmedCount = $event->getConfirmedGuestsCount();
        $expectedGuests = $event->expected_guests;
        
        // Если подтвержденных гостей больше или равно ожидаемым
        if ($confirmedCount >= $expectedGuests) {
            // Пометить всех неподтвержденных гостей как в списке ожидания
            Guest::updateAll(
                ['is_waiting' => 1],
                [
                    'event_id' => $event->id,
                    'status' => [Guest::STATUS_PENDING, Guest::STATUS_DECLINED]
                ]
            );
        } else {
            // Если есть места, снять отметку ожидания
            Guest::updateAll(
                ['is_waiting' => 0],
                [
                    'event_id' => $event->id,
                    'status' => Guest::STATUS_PENDING
                ]
            );
        }
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'Ожидает подтверждения'),
            self::STATUS_CONFIRMED => Yii::t('app', 'Подтвержден'),
            self::STATUS_DECLINED => Yii::t('app', 'Отказался'),
        ];
    }

   public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_PENDING => Yii::t('app', 'Ожидает подтверждения'),
            self::STATUS_CONFIRMED => Yii::t('app', 'Подтвержден'),
            self::STATUS_DECLINED => Yii::t('app', 'Отказался'),
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getViewUrl()
    {
        return ['guest/view', 'id' => $this->id];
    }
}
