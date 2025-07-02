<?php
use yii\helpers\Html;

/** @var app\models\Expense[] $expenses */
/** @var float $totalExpenses */
?>

<?php if (empty($expenses)): ?>
    <div class="alert alert-info">
        <?= Yii::t('app', 'Пока нет расходов.') ?>
    </div>
<?php else: ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Описание') ?></th>
                <th><?= Yii::t('app', 'Категория') ?></th>
                <th class="text-end"><?= Yii::t('app', 'Сумма') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?= Html::encode($expense->description) ?></td>
                <td><?= Html::encode($expense->category) ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asCurrency($expense->amount) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="table-success">
                <td colspan="2" class="text-end fw-bold"><?= Yii::t('app', 'Итого:') ?></td>
                <td class="text-end fw-bold"><?= Yii::$app->formatter->asCurrency($totalExpenses) ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>