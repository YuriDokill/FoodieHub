<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Task;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $events Список мероприятий */
/** @var array $users Список пользователей */
?>

<div class="task-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($events, 'id', 'title'),
        ['prompt' => Yii::t('app', 'Выберите мероприятие')]
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'deadline')->input('datetime-local') ?>

    <?= $form->field($model, 'assigned_to')->dropDownList(
        \yii\helpers\ArrayHelper::map($users, 'id', 'username'),
        ['prompt' => Yii::t('app', 'Выберите ответственного')]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(Task::getStatuses()) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success btn-lg']) ?>
        <?= Html::a(Yii::t('app', 'Отмена'), ['index'], ['class' => 'btn btn-outline-secondary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>