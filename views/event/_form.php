<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use app\models\EventCategory;

/** @var yii\web\View $this */
/** @var app\models\Event $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="event-form card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'format')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'expected_guests')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'event_date')->widget(DateTimePicker::class, [
                    'options' => ['placeholder' => 'Выберите дату и время'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'bsVersion' => '5',
                    ]
                ]) ?>
                
                <?= $form->field($model, 'cuisine_type')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'category_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(EventCategory::find()->all(), 'id', 'name'),
                    ['prompt' => 'Выберите категорию', 'class' => 'form-select']
                ) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            </div>
        </div>

        <div class="form-group mt-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <?= $form->field($model, 'organizer_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>