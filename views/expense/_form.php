<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\app\models\Expense;
use yii\app\models\Event;
use Yii;

/** @var yii\web\View $this */
/** @var app\models\Expense $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="expense-form">
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'event_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(Event::find()->all(), 'id', 'title'),
    ['prompt' => 'Выберите мероприятие']
) ?>

<?= $form->field($model, 'description')->textInput() ?>

<?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>

<?= $form->field($model, 'category')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
$('#expense-amount').on('input', function() {
    let total = parseFloat($('#budget-total').data('total'));
    let newAmount = parseFloat($(this).val()) || 0;
    let newTotal = total + newAmount;
    $('#budget-total').text(newTotal.toLocaleString('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 2
    }));
});
JS;

$this->registerJs($js);

