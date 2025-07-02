<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот рецепт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <h3>Описание</h3>
            <p><?= nl2br(Html::encode($model->description)) ?></p>
            
            <h3>Ингредиенты</h3>
            <p><?= nl2br(Html::encode($model->ingredients)) ?></p>
        </div>
        <div class="col-md-6">
            <h3>Инструкции</h3>
            <p><?= nl2br(Html::encode($model->instructions)) ?></p>
            
            <h3>Детали</h3>
            <p><strong>Время приготовления:</strong> <?= $model->cooking_time ?> мин</p>
            <p><strong>Сложность:</strong> <?= $model->difficulty ?></p>
            <p><strong>Автор:</strong> <?= $model->user->username ?? 'Неизвестно' ?></p>
        </div>
    </div>
</div>