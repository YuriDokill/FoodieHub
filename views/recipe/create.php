<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = 'Добавить рецепт';
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">
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
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>