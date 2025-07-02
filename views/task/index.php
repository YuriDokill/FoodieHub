<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Задачи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Здесь вы можете управлять задачами для мероприятий. Создавайте задачи, назначайте ответственных и отслеживайте их статус выполнения.
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Создать задачу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'deadline',
                'format' => 'datetime',
                'header' => Yii::t('app', 'Срок выполнения'),
            ],
            [
                'attribute' => 'assigned_to',
                'value' => function($model) {
                    return $model->assignedUser ? $model->assignedUser->username : null;
                },
                'header' => Yii::t('app', 'Ответственный'),
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                },
                'filter' => Task::getStatuses(),
                'header' => Yii::t('app', 'Статус'),
            ],
            [
                'attribute' => 'event_id',
                'value' => function($model) {
                    return $model->event ? $model->event->title : null;
                },
                'header' => Yii::t('app', 'Мероприятие'),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>