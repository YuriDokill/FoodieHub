<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Exception;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';
    
    public $password;
    public $password_repeat;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required', 'message' => Yii::t('app', 'Поле обязательно для заполнения')],
            ['email', 'email', 'message' => Yii::t('app', 'Некорректный email')],
            ['password', 'string', 'min' => 6, 'tooShort' => Yii::t('app', 'Пароль должен содержать минимум 6 символов')],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Пароли не совпадают')],
            [['username', 'email'], 'unique', 'message' => Yii::t('app', 'Это значение уже занято')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
         return [
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повторите пароль'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
            $this->setPassword($this->password);
            $this->created_at = time();
        }
        $this->updated_at = time();
        
        return parent::beforeSave($insert);
    }

    /**
     * Устанавливает пароль
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    // Реализация методов IdentityInterface...
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}