<?php
use yii\helpers\Html;

/* @var $task app\models\Task */
?>
<h2>Вам назначена новая задача</h2>
<p><strong>Название:</strong> <?= Html::encode($task->title) ?></p>
<p><strong>Описание:</strong> <?= Html::encode($task->description) ?></p>
<p><strong>Срок выполнения:</strong> <?= Yii::$app->formatter->asDatetime($task->deadline) ?></p>
<p><strong>Статус:</strong> <?= $task->getStatusLabel() ?></p>