<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = 'Редактировать рецепт: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="recipe-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'cooking_time')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'difficulty')->dropDownList([
                'Легко' => 'Легко',
                'Средне' => 'Средне',
                'Сложно' => 'Сложно'
            ]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'ingredients')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'instructions')->textarea(['rows' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>