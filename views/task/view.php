<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Задачи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить эту задачу?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'description:ntext',
                    [
                        'attribute' => 'deadline',
                        'format' => 'datetime',
                        'label' => Yii::t('app', 'Срок выполнения'),
                    ],
                    [
                        'attribute' => 'assigned_to',
                        'value' => $model->assignedUser ? $model->assignedUser->username : null,
                        'label' => Yii::t('app', 'Ответственный'),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => $model->getStatusLabel(),
                        'label' => Yii::t('app', 'Статус'),
                    ],
                    [
                        'attribute' => 'event_id',
                        'value' => $model->event ? $model->event->title : null,
                        'label' => Yii::t('app', 'Мероприятие'),
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>