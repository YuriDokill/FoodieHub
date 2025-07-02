<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Event;
use app\models\Guest;

/** @var yii\web\View $this */
/** @var app\models\Guest $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $events Список мероприятий */
?>

<div class="guest-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($events, 'id', 'title'),
        ['prompt' => Yii::t('app', 'Выберите мероприятие')]
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        Guest::getStatuses(), 
        ['prompt' => Yii::t('app', 'Выберите статус')]
    ) ?>

    <?= $form->field($model, 'is_waiting')->checkbox([
        'label' => Yii::t('app', 'В списке ожидания'),
        'disabled' => $model->status == Guest::STATUS_CONFIRMED
    ]) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-lg']) ?>
        <?= Html::a(Yii::t('app', 'Отмена'), ['index'], ['class' => 'btn btn-outline-secondary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>