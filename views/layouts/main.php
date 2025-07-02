<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">

    <?php $this->registerCssFile('@web/css/site.css') ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/ru.min.js"></script>
    <?php $this->registerCssFile('@web/css/site.css') ?>
    
    <!-- Ваши кастомные стили -->
    <style>
        body {
            padding-top: 60px;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">FoodieHub</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/event/index']) ?>">Мероприятия</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/recipe/index']) ?>">Рецепты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/restaurant/index']) ?>">Рестораны</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/event/calendar']) ?>">Календарь</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/task/index']) ?>">Задачи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/guest/index']) ?>">Гости</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/expense/index']) ?>">Бюджет</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/site/login']) ?>">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/site/signup']) ?>">Регистрация</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline']) ?>
                                <?= Html::submitButton(
                                    'Выход (' . Yii::$app->user->identity->username . ')',
                                    ['class' => 'btn btn-link nav-link']
                                ) ?>
                            <?= Html::endForm() ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container py-4">
    <?= $content ?>
</main>

<footer class="footer mt-auto py-4">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo mb-3">
                <i class="bi bi-egg-fried fs-2"></i>
                <h3 class="d-inline-block ms-2">FoodieHub</h3>
            </div>
            <p class="mb-3">Сообщество для настоящих гурманов. Делитесь рецептами, находите рестораны, участвуйте в мероприятиях!</p>
            <p class="footer-copyright">© <?= date('Y') ?> FoodieHub. Все права защищены.</p>
        </div>
    </div>
</footer>

<!-- Подключаем Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Логирование JavaScript ошибок
window.onerror = function(message, source, lineno, colno, error) {
    console.error("JavaScript Error:", message, "at", source, "line", lineno);
    alert("JavaScript Error: " + message + "\nCheck console for details");
    return true;
};

// Отладка отправки формы
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('event-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log("Форма отправлена");
            console.log("Данные формы:", new FormData(form));
        });
    }
});
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>