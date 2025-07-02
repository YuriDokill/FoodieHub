<?php
use yii\helpers\Html;

/** @var app\models\Guest $guest */
?>
<h2>Новый гость для мероприятия: <?= Html::encode($guest->event->title) ?></h2>

<p><strong>Имя:</strong> <?= Html::encode($guest->name) ?></p>
<p><strong>Контактная информация:</strong> <?= Html::encode($guest->contact_info) ?></p>
<p><strong>Статус:</strong> <?= $guest->getStatusLabel() ?></p>
<p><strong>В списке ожидания:</strong> <?= $guest->is_waiting ? 'Да' : 'Нет' ?></p>

<p>Перейдите в систему для просмотра: 
<?= Html::a('FoodieHub', Yii::$app->urlManager->createAbsoluteUrl($guest->viewUrl)) ?></p>