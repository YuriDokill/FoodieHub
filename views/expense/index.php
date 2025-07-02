<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Расходы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Управление списком гостей для ваших мероприятий. Добавляйте гостей, отслеживайте их статус участия и управляйте списком ожидания.
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить расход'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'description',
            [
                'attribute' => 'amount',
                'format' => 'currency',
                'header' => Yii::t('app', 'Сумма'),
            ],
            'category',
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