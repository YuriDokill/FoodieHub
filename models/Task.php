<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DELAYED = 'delayed';

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    
        // if ($insert || (isset($changedAttributes['assigned_to']) && $this->assigned_to)) {
        //     $user = User::findOne($this->assigned_to);
        //     if ($user && $user->email) {
        //         Yii::$app->mailer->compose('taskAssignment', ['task' => $this])
        //             ->setTo($user->email)
        //             ->setSubject('Новая задача: ' . $this->title)
        //             ->send();
        //     }
        // }
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'title', 'deadline', 'status'], 'required'],
            [['event_id', 'assigned_to'], 'integer'],
            [['description'], 'string'],
            [['deadline'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['assigned_to' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Мероприятие',
            'title' => 'Название',
            'description' => 'Описание',
            'deadline' => 'Срок выполнения',
            'assigned_to' => 'Ответственный',
            'status' => 'Статус',
        ];
    }

    public function getAssignedUser()
    {
        return $this->hasOne(User::class, ['id' => 'assigned_to']);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'В ожидании'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'В процессе'),
            self::STATUS_COMPLETED => Yii::t('app', 'Завершено'),
            self::STATUS_DELAYED => Yii::t('app', 'Просрочено'),
        ];
    }

    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_PENDING => Yii::t('app', 'В ожидании'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'В процессе'),
            self::STATUS_COMPLETED => Yii::t('app', 'Завершено'),
            self::STATUS_DELAYED => Yii::t('app', 'Просрочено'),
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        
        if ($this->deadline) {
            $this->deadline = Yii::$app->formatter->asDatetime($this->deadline, 'yyyy-MM-ddTHH:mm');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->deadline) {
                $this->deadline = date('Y-m-d H:i:s', strtotime($this->deadline));
            }
            return true;
        }
        return false;
    }
}
