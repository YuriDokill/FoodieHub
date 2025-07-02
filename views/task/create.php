<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var array $events Список мероприятий */
/** @var array $users Список пользователей */

$this->title = Yii::t('app', 'Создать задачу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Задачи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'events' => $events,
                'users' => $users,
            ]) ?>
        </div>
    </div>
</div>