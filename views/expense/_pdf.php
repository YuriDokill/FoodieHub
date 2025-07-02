<?php
use yii\helpers\Html;
?>
<style>
body {
    font-family: Arial, sans-serif;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #000;
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
.total-row {
    font-weight: bold;
}
</style>
<h1>Отчет по бюджету: <?= Html::encode($event->title) ?></h1>
<p><strong>Дата:</strong> <?= date('d.m.Y') ?></p>

<table>
    <thead>
        <tr>
            <th>Описание</th>
            <th>Категория</th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($expenses as $expense): ?>
        <tr>
            <td><?= Html::encode($expense->description) ?></td>
            <td><?= Html::encode($expense->category) ?></td>
            <td><?= number_format($expense->amount, 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="total-row">
            <td colspan="2">Итого:</td>
            <td><?= number_format($total, 2) ?></td>
        </tr>
    </tbody>
</table>