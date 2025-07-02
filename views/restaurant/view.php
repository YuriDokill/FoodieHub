<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рестораны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот ресторан?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="restaurant-details">
                <p><strong>Адрес:</strong> <?= Html::encode($model->address) ?></p>
                <p><strong>Телефон:</strong> <?= Html::encode($model->phone) ?></p>
                <p><strong>Тип кухни:</strong> <?= Html::encode($model->cuisine_type) ?></p>
                <p><strong>Рейтинг:</strong> <?= Html::encode($model->rating) ?>/5</p>
                <p><strong>Веб-сайт:</strong> <?= Html::a($model->website, $model->website, ['target' => '_blank']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="restaurant-description">
                <h3>Описание</h3>
                <p><?= nl2br(Html::encode($model->description)) ?></p>
            </div>
        </div>
    </div>

    <div class="restaurant-map mt-4">
        <h3>Расположение</h3>
        <div id="map" style="height: 300px; width: 100%;"></div>
    </div>
</div>

<?php
// Простой пример карты (для реального проекта используйте API Яндекс.Карт или Google Maps)
$this->registerJs(<<<JS
// Заглушка для карты - в реальном проекте здесь будет код инициализации карты
console.log('Инициализация карты для ресторана: {$model->name}');
JS
);
?>