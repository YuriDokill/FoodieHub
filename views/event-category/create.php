<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EventCategory $model */

$this->title = 'Create Event Category';
$this->params['breadcrumbs'][] = ['label' => 'Event Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
