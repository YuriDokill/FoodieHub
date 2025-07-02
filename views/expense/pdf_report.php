<?php
use yii\helpers\Html;

$this->title = 'Бюджетный отчет: ' . Html::encode($event->title);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $this->title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { font-size: 18px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .total-row td { font-weight: bold; text-align: right; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <h1>Отчет по бюджету: <?= Html::encode($event->title) ?></h1>
    <p><strong>Дата составления:</strong> <?= date('d.m.Y') ?></p>
    
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
    
    <div class="footer">
        <p>Сгенерировано в FoodieHub</p>
    </div>
</body>
</html>