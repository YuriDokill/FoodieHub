<?php

use yii\db\Migration;

class m250629_230304_add_test_restaurants extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('restaurant', 
            ['name', 'address', 'phone', 'cuisine_type', 'description', 'rating', 'website', 'created_at', 'updated_at'],
            [
                [
                    'La Bella Italia',
                    'ул. Гастрономическая, 15',
                    '+7 (495) 123-45-67',
                    'Итальянская',
                    'Аутентичная итальянская кухня с домашней пастой и пиццей, приготовленной в дровяной печи. Уютная атмосфера и отличное вино.',
                    4.8,
                    'https://labellaitalia.ru',
                    time(),
                    time()
                ],
                [
                    'Le Petit Paris',
                    'ул. Французская, 22',
                    '+7 (495) 765-43-21',
                    'Французская',
                    'Элегантный ресторан французской кухни с изысканным меню и обширной винной картой. Идеальное место для романтического ужина.',
                    4.9,
                    'https://lepetitparis.ru',
                    time(),
                    time()
                ],
                [
                    'Токио Суши',
                    'пр. Восточный, 5',
                    '+7 (495) 555-55-55',
                    'Японская',
                    'Современный ресторан японской кухни с широким выбором суши, роллов и горячих блюд. Свежайшие морепродукты ежедневно.',
                    4.5,
                    'https://tokyosushi.ru',
                    time(),
                    time()
                ],
                [
                    'Мясной Клуб',
                    'ул. Грильная, 40',
                    '+7 (495) 999-88-77',
                    'Стейк-хаус',
                    'Лучшие стейки в городе от аргентинского шеф-повара. Большой выбор мясных блюд и авторских соусов.',
                    4.7,
                    'https://meatclub.ru',
                    time(),
                    time()
                ]
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('restaurant', ['name' => [
            'La Bella Italia',
            'Le Petit Paris',
            'Токио Суши',
            'Мясной Клуб'
        ]]);
    }
}
