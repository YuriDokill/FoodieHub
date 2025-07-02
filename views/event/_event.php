<?php

use yii\helpers\Html;

?>

<div class="event-item">
    <h3><?= Html::a($model->title, ['event/view', 'id' => $model->id]) ?></h3>
    <p>
        <strong>Дата:</strong> <?= Yii::$app->formatter->asDatetime($model->event_date) ?><br>
        <strong>Место:</strong> <?= Html::encode($model->location) ?><br>
        <strong>Формат:</strong> <?= Html::encode($model->format) ?>
    </p>
    <p><?= Html::encode(mb_substr($model->description, 0, 200)) ?>...</p>
    <div class="text-right">
        <?= Html::a('Подробнее', ['event/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

