<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Guest[] $guests */
?>

<?php if (empty($guests)): ?>
    <div class="alert alert-info">
        <?= Yii::t('app', 'Пока нет гостей.') ?>
        <?= Html::a(Yii::t('app', 'Добавить гостя'), ['guest/create', 'event_id' => $guests[0]->event_id ?? null]) ?>
    </div>
<?php else: ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Имя') ?></th>
                <th><?= Yii::t('app', 'Контакт') ?></th>
                <th><?= Yii::t('app', 'Статус') ?></th>
                <th><?= Yii::t('app', 'Ожидание') ?></th>
                <th><?= Yii::t('app', 'Действия') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guests as $guest): ?>
            <tr class="<?= $guest->is_waiting ? 'table-warning' : '' ?>">
                <td><?= Html::encode($guest->name) ?></td>
                <td><?= Html::encode($guest->contact_info) ?></td>
                <td><?= $guest->getStatusLabel() ?></td>
                <td><?= $guest->is_waiting ? Yii::t('app', 'Да') : Yii::t('app', 'Нет') ?></td>
                <td>
                    <?= Html::a(
                        '<i class="bi bi-pencil"></i>', 
                        ['guest/update', 'id' => $guest->id], 
                        ['class' => 'btn btn-sm btn-outline-primary', 'title' => Yii::t('app', 'Редактировать')]
                    ) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>