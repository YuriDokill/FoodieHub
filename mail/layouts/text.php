<?php
use yii\helpers\Html;

/* @var $task app\models\Task */
?>
<h2>Вам назначена новая задача</h2>
<p><strong>Событие:</strong> <?= Html::encode($task->event->title) ?></p>
<p><strong>Задача:</strong> <?= Html::encode($task->title) ?></p>
<p><strong>Описание:</strong> <?= Html::encode($task->description) ?></p>
<p><strong>Срок:</strong> <?= Yii::$app->formatter->asDatetime($task->deadline) ?></p>
<p><strong>Статус:</strong> <?= $task->status ?></p>
<p>Перейдите в систему для выполнения задачи: 
<?= Html::a('FoodieHub', Yii::$app->urlManager->createAbsoluteUrl(['/task/view', 'id' => $task->id])) ?></p>