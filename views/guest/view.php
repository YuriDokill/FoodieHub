<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Guest $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Гости'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-view">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этого гостя?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'contact_info',
                    [
                        'attribute' => 'status',
                        'value' => $model->getStatusLabel(),
                    ],
                    [
                        'attribute' => 'is_waiting',
                        'value' => $model->is_waiting ? Yii::t('app', 'Да') : Yii::t('app', 'Нет'),
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
    
    <div class="text-center">
        <?= Html::a(
            Yii::t('app', 'Вернуться к мероприятию'), 
            ['event/view', 'id' => $model->event_id], 
            ['class' => 'btn btn-outline-primary']
        ) ?>
    </div>
</div>