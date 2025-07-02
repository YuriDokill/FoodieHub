<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'enableClientValidation' => false,
            ]); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-primary w-100', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            
            <div class="text-center mt-3">
                <p>
                    <?= Yii::t('app', 'Уже зарегистрированы?') ?> 
                    <?= Html::a(Yii::t('app', 'Войти'), ['site/login']) ?>
                </p>
            </div>
        </div>
    </div>
</div>