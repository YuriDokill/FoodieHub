<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $guests app\models\Guest[] */
/* @var $expenses app\models\Expense[] */
/* @var $tasks app\models\Task[] */
/* @var $totalExpenses float */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Мероприятия'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить это мероприятие?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="mb-3"><?= Yii::t('app', 'Описание') ?></h3>
                    <p><?= nl2br(Html::encode($model->description)) ?></p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5><i class="bi bi-geo-alt"></i> <?= Yii::t('app', 'Место проведения') ?></h5>
                            <p><?= Html::encode($model->location) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-calendar-event"></i> <?= Yii::t('app', 'Дата и время') ?></h5>
                            <p><?= Yii::$app->formatter->asDatetime($model->event_date) ?></p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5><i class="bi bi-people"></i> <?= Yii::t('app', 'Ожидаемое кол-во гостей') ?></h5>
                            <p><?= $model->expected_guests ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="bi bi-tags"></i> <?= Yii::t('app', 'Категория') ?></h5>
                            <p><?= $model->category ? $model->category->name : '' ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title"><?= Yii::t('app', 'Организатор') ?></h5>
                            <p class="card-text">
                                <?= $model->organizer ? $model->organizer->username : '' ?>
                            </p>
                            
                            <h5 class="card-title mt-4"><?= Yii::t('app', 'Общий бюджет') ?></h5>
                            <p class="card-text fs-4 fw-bold text-success">
                                <?= Yii::$app->formatter->asCurrency($totalExpenses) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок гостей -->
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><?= Yii::t('app', 'Гости') ?></h3>
            <div>
                <span class="badge bg-success me-2">
                    <?= Yii::t('app', 'Подтверждено: {count}/{max}', [
                        'count' => $model->getConfirmedGuestsCount(),
                        'max' => $model->expected_guests
                    ]) ?>
                </span>
                <?= Html::a(
                    '<i class="bi bi-plus-circle"></i> ' . Yii::t('app', 'Добавить гостя'), 
                    ['guest/create', 'event_id' => $model->id], 
                    ['class' => 'btn btn-sm btn-primary']
                ) ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_guests', ['guests' => $guests]) ?>
        </div>
    </div>

    <!-- Блок задач -->
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><?= Yii::t('app', 'Задачи') ?></h3>
            <?= Html::a(
                '<i class="bi bi-plus-circle"></i> ' . Yii::t('app', 'Добавить задачу'), 
                ['task/create', 'event_id' => $model->id], 
                ['class' => 'btn btn-sm btn-primary']
            ) ?>
        </div>
        <div class="card-body">
            <?= $this->render('_tasks', ['tasks' => $tasks]) ?>
        </div>
    </div>

    <!-- Блок расходов -->
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><?= Yii::t('app', 'Расходы') ?></h3>
            <div>
                <?= Html::a(
                    '<i class="bi bi-plus-circle"></i> ' . Yii::t('app', 'Добавить расход'), 
                    ['expense/create', 'event_id' => $model->id], 
                    ['class' => 'btn btn-sm btn-primary me-2']
                ) ?>
                <?= Html::a(
                    '<i class="bi bi-file-earmark-pdf"></i> PDF', 
                    ['expense/export-pdf', 'event_id' => $model->id], 
                    ['class' => 'btn btn-sm btn-outline-danger']
                ) ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_expenses', [
                'expenses' => $expenses,
                'totalExpenses' => $totalExpenses
            ]) ?>
        </div>
    </div>
</div>