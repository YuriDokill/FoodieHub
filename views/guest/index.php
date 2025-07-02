<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Guest;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GuestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Гости');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Управление списком гостей для ваших мероприятий. Добавляйте гостей, отслеживайте их статус участия и управляйте списком ожидания.
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить гостя'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'contact_info',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusLabel();
                },
                'filter' => Guest::getStatuses(),
            ],
            [
                'attribute' => 'is_waiting',
                'value' => function($model) {
                    return $model->is_waiting ? Yii::t('app', 'Да') : Yii::t('app', 'Нет');
                },
                'filter' => [0 => Yii::t('app', 'Нет'), 1 => Yii::t('app', 'Да')],
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