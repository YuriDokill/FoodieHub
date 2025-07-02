<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мероприятия';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать мероприятие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'event_date:datetime',
            'location',
            [
                'attribute' => 'organizer_id',
                'value' => function($model) {
                    return $model->organizer->username;
                }
            ],
            [
                'class' => ActionColumn::class,
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'Действия',
                'template' => '{view} {update} {delete}',
                'buttonOptions' => ['class' => 'btn btn-sm'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<i class="bi bi-eye"></i>', $url, [
                            'class' => 'btn btn-info',
                            'title' => 'Просмотр'
                        ]);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="bi bi-pencil"></i>', $url, [
                            'class' => 'btn btn-primary',
                            'title' => 'Редактировать'
                        ]);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<i class="bi bi-trash"></i>', $url, [
                            'class' => 'btn btn-danger',
                            'title' => 'Удалить',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить это мероприятие?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>