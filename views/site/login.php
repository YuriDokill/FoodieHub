<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            
            <div class="text-center mt-3">
                <p>
                    <?= Yii::t('app', 'Еще не зарегистрированы?') ?> 
                    <?= Html::a(Yii::t('app', 'Создать аккаунт'), ['site/signup']) ?>
                </p>
            </div>
        </div>
    </div>
</div>