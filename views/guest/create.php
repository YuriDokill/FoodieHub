<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Guest $model */
/** @var array $events Список мероприятий */

$this->title = Yii::t('app', 'Добавить гостя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Гости'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-create">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'events' => $events,
            ]) ?>
        </div>
    </div>
</div>