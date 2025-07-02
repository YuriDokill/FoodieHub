<?php
use yii\helpers\Html;
use app\models\Task;

/** @var app\models\Task[] $tasks */
?>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info">
        <?= Yii::t('app', 'Пока нет задач.') ?>
    </div>
<?php else: ?>
    <div class="list-group">
        <?php foreach ($tasks as $task): ?>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?= Html::encode($task->title) ?></h5>
                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($task->deadline) ?></small>
            </div>
            <p class="mb-1"><?= nl2br(Html::encode($task->description)) ?></p>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>
                    <span class="badge bg-<?= 
                        $task->status == Task::STATUS_COMPLETED ? 'success' : 
                        ($task->status == Task::STATUS_IN_PROGRESS ? 'primary' : 
                        ($task->status == Task::STATUS_DELAYED ? 'danger' : 'warning')) 
                    ?>">
                        <?= $task->getStatusLabel() ?>
                    </span>
                    <?php if ($task->assigned_to): ?>
                        <span class="badge bg-info ms-2">
                            <?= $task->assignedUser ? $task->assignedUser->username : '' ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?= Html::a(
                    '<i class="bi bi-pencil"></i>', 
                    ['task/update', 'id' => $task->id], 
                    ['class' => 'btn btn-sm btn-outline-primary', 'title' => Yii::t('app', 'Редактировать')]
                ) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>