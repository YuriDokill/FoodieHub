<?php
use app\models\Event as EventModel;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="event-calendar">
    <div class="row">
        <div class="col-md-3">
            <div class="filters">
                <h4>Фильтры</h4>
                <?= Html::beginForm(['event/filter'], 'get', ['id' => 'filter-form']) ?>
                    <div class="form-group">
                        <label>Категория</label>
                        <?= Html::dropDownList('category_id', null, 
                            \yii\helpers\ArrayHelper::map($categories, 'id', 'name'), 
                            ['class' => 'form-control', 'prompt' => 'Все категории']) ?>
                    </div>
                    <div class="form-group">
                        <label>Локация</label>
                        <?= Html::textInput('location', null, ['class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <label>Уровень мастерства</label>
                        <?= Html::dropDownList('skill_level', null, 
                            EventModel::getSkillLevels(),
                            ['class' => 'form-control', 'prompt' => 'Все уровни']) ?>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: $('#filter-form').attr('action'),
                data: $('#filter-form').serialize(),
                success: function(data) {
                    successCallback(data);
                }
            });
        }
    });
    calendar.render();
    
    $('#filter-form select, #filter-form input').change(function() {
        calendar.refetchEvents();
    });
});
JS;
$this->registerJs($js);
?>