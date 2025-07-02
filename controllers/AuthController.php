<?php

namespace app\controllers;

use Yii;
use app\models\User;

class AuthController extends \yii\web\Controller
{
    public function actionRegister()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER; // Установка сценария

        if ($model->load(Yii::$app->request->post())) {
            // Пароль приходит из формы в виртуальное поле 'password'
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->user->login($model);
                    return $this->goHome();
                }
            }
        }
        return $this->render('register', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}