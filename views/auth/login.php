<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */
/* @var $form ActiveForm */
?>

<div class="auth-login">
    <h1>Вход</h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        
        <?= $form->field($model, 'password')->passwordInput() ?>
        
        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        
        <div class="form-group" style="margin-top: 20px;">
            <?= Html::a('Регистрация', ['auth/register'], ['class' => 'btn btn-link']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>