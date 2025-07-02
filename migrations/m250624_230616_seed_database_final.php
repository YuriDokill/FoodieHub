<?php

use yii\db\Migration;
use app\models\User;
use app\models\EventCategory;
use app\models\Event;
use app\models\Guest;
use app\models\Task;
use app\models\Expense;
use app\models\Recipe;
use app\models\Restaurant;

class m250624_230616_seed_database_final extends Migration
{
    public function safeUp()
    {
        // Создаем пользователей
        $users = [
            [
                'username' => 'chef_ivan',
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ],
            [
                'username' => 'gourmet_olga',
                'email' => 'olga@example.com',
                'password' => 'gourmet_pass',
            ],
            [
                'username' => 'restaurant_expert',
                'email' => 'expert@example.com',
                'password' => 'expert123',
            ],
        ];
        
        foreach ($users as $userData) {
            $user = new User();
            $user->scenario = User::SCENARIO_REGISTER;
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->password = $userData['password'];
            $user->save();
        }
        
        // Создаем категории мероприятий
        $categories = [
            ['name' => 'Мастер-класс'],
            ['name' => 'Ужин'],
            ['name' => 'Фестиваль'],
            ['name' => 'Дегустация'],
            ['name' => 'Кулинарный поединок'],
        ];
        
        foreach ($categories as $category) {
            $cat = new EventCategory();
            $cat->name = $category['name'];
            $cat->save();
        }
        
        // Создаем мероприятия
        $events = [
            [
                'title' => 'Мастер-класс по итальянской кухне',
                'description' => 'Учимся готовить пасту и ризотто',
                'event_date' => date('Y-m-d H:i:s', strtotime('+1 week')),
                'location' => 'Кулинарная студия "Вкус"',
                'format' => 'Мастер-класс',
                'cuisine_type' => 'Итальянская',
                'expected_guests' => 15,
                'category_id' => EventCategory::find()->where(['name' => 'Мастер-класс'])->one()->id,
                'organizer_id' => User::find()->where(['username' => 'chef_ivan'])->one()->id,
            ],
            [
                'title' => 'Веганский ужин',
                'description' => 'Ужин в веганском стиле с шеф-поваром',
                'event_date' => date('Y-m-d H:i:s', strtotime('+2 weeks')),
                'location' => 'Ресторан "Зеленая тарелка"',
                'format' => 'Ужин',
                'cuisine_type' => 'Веганская',
                'expected_guests' => 20,
                'category_id' => EventCategory::find()->where(['name' => 'Ужин'])->one()->id,
                'organizer_id' => User::find()->where(['username' => 'gourmet_olga'])->one()->id,
            ],
        ];
        
        foreach ($events as $eventData) {
            $event = new Event();
            $event->title = $eventData['title'];
            $event->description = $eventData['description'];
            $event->event_date = $eventData['event_date'];
            $event->location = $eventData['location'];
            $event->format = $eventData['format'];
            $event->cuisine_type = $eventData['cuisine_type'];
            $event->expected_guests = $eventData['expected_guests'];
            $event->category_id = $eventData['category_id'];
            $event->organizer_id = $eventData['organizer_id'];
            $event->created_at = time();
            $event->updated_at = time();
    
            if (!$event->save()) {
                print_r($event->errors);
                die();
            }
            
            // Добавляем гостей
            $guests = [
                ['name' => 'Алексей Петров', 'contact_info' => 'alex@mail.com', 'status' => Guest::STATUS_CONFIRMED],
                ['name' => 'Мария Сидорова', 'contact_info' => 'maria@mail.com', 'status' => Guest::STATUS_PENDING],
                ['name' => 'Иван Иванов', 'contact_info' => 'ivan@mail.com', 'status' => Guest::STATUS_CONFIRMED],
            ];
            
            foreach ($guests as $guestData) {
                $guest = new Guest();
                $guest->event_id = $event->id;
                $guest->setAttributes($guestData);
                $guest->save();
            }
            
            // Добавляем задачи
            $tasks = [
                [
                    'title' => 'Закупка ингредиентов',
                    'description' => 'Купить продукты для мастер-класса',
                    'deadline' => date('Y-m-d H:i:s', strtotime('-2 days', strtotime($event->event_date))),
                    'assigned_to' => User::find()->where(['username' => 'chef_ivan'])->one()->id,
                    'status' => Task::STATUS_PENDING,
                ],
                [
                    'title' => 'Подготовка помещения',
                    'description' => 'Подготовить кухню к мероприятию',
                    'deadline' => date('Y-m-d H:i:s', strtotime('-1 day', strtotime($event->event_date))),
                    'assigned_to' => User::find()->where(['username' => 'restaurant_expert'])->one()->id,
                    'status' => Task::STATUS_IN_PROGRESS,
                ],
            ];
            
            foreach ($tasks as $taskData) {
                $task = new Task();
                $task->event_id = $event->id;
                $task->setAttributes($taskData);
                $task->save();
            }
            
            // Добавляем расходы
            $expenses = [
                ['description' => 'Продукты', 'amount' => 15000.00, 'category' => 'Питание'],
                ['description' => 'Аренда помещения', 'amount' => 8000.00, 'category' => 'Аренда'],
            ];
            
            foreach ($expenses as $expenseData) {
                $expense = new Expense();
                $expense->event_id = $event->id;
                $expense->setAttributes($expenseData);
                $expense->save();
            }
        }
    }

    public function safeDown()
    {
        echo "Миграция не может быть отменена.\n";
        return false;
    }
}
