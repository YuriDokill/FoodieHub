<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Event;

$this->title = 'FoodieHub - Сообщество гастрономов';
?>

<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать в FoodieHub!</h1>
        <p class="lead">Сообщество для любителей вкусной еды и кулинарных экспериментов</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h2>Ближайшие мероприятия</h2>
            <?= ListView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => Event::find()->orderBy('event_date ASC')->limit(5),
                ]),
                'itemView' => '@app/views/event/_event',
                'layout' => "{items}\n{pager}",
            ]) ?>

        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Быстрые ссылки</div>
                <div class="panel-body">
                    <ul>
                        <li><?= Html::a('Создать мероприятие', ['event/create']) ?></li>
                        <li><?= Html::a('Добавить рецепт', ['recipe/create']) ?></li>
                        <li><?= Html::a('Добавить ресторан', ['restaurant/create']) ?></li>
                        <li><?= Html::a('Календарь событий', ['event/calendar']) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
