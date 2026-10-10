<?php

return [
    'meta_title' => 'Контакты I MUST',
    'meta_description' => 'Приходите в офис I MUST в Аване, Ереван, или напишите нам.',

    'title' => 'Давайте поговорим о вашем бизнесе.',
    'lead' => 'Приходите в наш офис в Аване или напишите нам.',

    'office' => [
        'title' => 'Офис',
        'city' => 'Аван, Ереван',
        'lines' => ['Первый этаж', 'Отдельный вход', 'Двор'],
        'email' => 'Email',
        'phone' => 'Телефон',
        'map' => 'Открыть в Google Maps',
        'image_alt' => 'Вход в офис I MUST',
    ],

    'form' => [
        'title' => 'Отправить сообщение',
        'name' => 'Ваше имя',
        'company' => 'Компания',
        'email' => 'Email',
        'phone' => 'Телефон',
        'optional' => 'Необязательно',
        'package' => 'Пакет',
        'package_unsure' => 'Пока не знаю',
        'message' => 'Сообщение',
        'message_hint' => 'Пара строк о вашем бизнесе и целях.',
        'submit' => 'Отправить',
        'errors' => [
            'name' => 'Введите ваше имя.',
            'email' => 'Введите корректный email.',
            'message' => 'Расскажите немного о проекте.',
        ],
        // TODO: remove once the form is connected to a mail service.
        'not_connected' => 'Онлайн-отправка пока не подключена. Напишите нам на hello@imust.am.',
    ],
];
